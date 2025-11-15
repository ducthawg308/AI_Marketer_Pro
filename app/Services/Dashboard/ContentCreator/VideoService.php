<?php

namespace App\Services\Dashboard\ContentCreator;

use App\Models\Dashboard\ContentCreator\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoService
{
    /**
     * Upload and process video
     */
    public function uploadVideo(UploadedFile $file, array $data): Video
    {
        $userId = $data['user_id'];
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        // Store the video
        $path = $file->storeAs('videos/' . $userId, $filename, 'public');

        // Create video record first
        $video = Video::create([
            'user_id' => $userId,
            'title' => $data['title'] ?? pathinfo($originalName, PATHINFO_FILENAME),
            'description' => $data['description'] ?? null,
            'original_filename' => $originalName,
            'original_path' => $path,
            'duration' => null,
            'width' => null,
            'height' => null,
            'file_size' => $file->getSize(),
            'format' => null,
            'codec' => null,
            'status' => 'uploaded',
        ]);

        try {
            // Get video information using FFprobe
            $videoInfo = $this->getVideoInfo(storage_path('app/public/' . $path));

            // Generate thumbnail
            $thumbnailPath = $this->generateThumbnail(storage_path('app/public/' . $path), $userId);

            // Update video record with metadata
            $video->update([
                'thumbnail_path' => $thumbnailPath,
                'duration' => $videoInfo['duration'] ?? null,
                'width' => $videoInfo['width'] ?? null,
                'height' => $videoInfo['height'] ?? null,
                'format' => $videoInfo['format'] ?? null,
                'codec' => $videoInfo['codec'] ?? null,
            ]);

        } catch (\Exception $e) {
            // If FFprobe fails, still keep the video but log the error
            Log::error('Error getting video info for video ID ' . $video->id . ': ' . $e->getMessage());
            // Video still uploaded but without metadata
        }

        return $video->fresh();
    }

    /**
     * Get video information using FFprobe
     */
    private function getVideoInfo(string $videoPath): array
    {
        try {
            $ffprobe = $this->getFFprobePath();
            
            // Get video duration
            $durationCmd = "$ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 \"$videoPath\"";
            $duration = shell_exec($durationCmd);
            
            // Get video dimensions
            $dimensionsCmd = "$ffprobe -v error -select_streams v:0 -show_entries stream=width,height -of csv=s=x:p=0 \"$videoPath\"";
            $dimensions = shell_exec($dimensionsCmd);
            
            // Get format
            $formatCmd = "$ffprobe -v error -show_entries format=format_name -of default=noprint_wrappers=1:nokey=1 \"$videoPath\"";
            $format = shell_exec($formatCmd);
            
            // Get codec
            $codecCmd = "$ffprobe -v error -select_streams v:0 -show_entries stream=codec_name -of default=noprint_wrappers=1:nokey=1 \"$videoPath\"";
            $codec = shell_exec($codecCmd);
            
            list($width, $height) = array_pad(explode('x', trim($dimensions ?? '')), 2, null);
            
            return [
                'duration' => (int) floatval(trim($duration ?? 0)),
                'width' => (int) $width,
                'height' => (int) $height,
                'format' => trim($format ?? ''),
                'codec' => trim($codec ?? ''),
            ];
        } catch (\Exception $e) {
            Log::error('Error getting video info: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Generate thumbnail from video
     */
    private function generateThumbnail(string $videoPath, int $userId): ?string
    {
        try {
            $ffmpeg = $this->getFFmpegPath();
            $thumbnailFilename = time() . '_thumb_' . Str::random(10) . '.jpg';
            $thumbnailPath = 'videos/' . $userId . '/thumbnails/' . $thumbnailFilename;
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);
            
            // Create directory if it doesn't exist
            $dir = dirname($fullThumbnailPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Generate thumbnail at 1 second
            $cmd = "$ffmpeg -i \"$videoPath\" -ss 00:00:01.000 -vframes 1 \"$fullThumbnailPath\" 2>&1";
            shell_exec($cmd);
            
            return file_exists($fullThumbnailPath) ? $thumbnailPath : null;
        } catch (\Exception $e) {
            Log::error('Error generating thumbnail: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Trim video
     */
    public function trimVideo(int $videoId, float $startTime, float $endTime): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);

        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            $duration = $endTime - $startTime;

            $outputFilename = time() . '_trimmed_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);

            // Create directory if needed
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Trim command - use a more compatible approach for FFmpeg 8.0
            $cmd = "$ffmpeg -y -i \"$inputPath\" -ss $startTime -t $duration -c:v copy -c:a copy \"$fullOutputPath\"";
            Log::info("Trim command: $cmd");

            $output = [];
            $returnVar = 0;
            $result = exec($cmd . ' 2>&1', $output, $returnVar);
            $outputTxt = implode("\n", $output);

            Log::info("Trim exec result code: $returnVar");
            Log::info("Trim exec output: $outputTxt");

            if ($returnVar !== 0) {
                Log::error("Trim failed with code $returnVar: $outputTxt");
                throw new \Exception("FFmpeg trim failed: $outputTxt");
            }
            
            if (file_exists($fullOutputPath)) {
                // Update video record
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'trim',
                    'params' => ['start_time' => $startTime, 'end_time' => $endTime],
                    'timestamp' => now()->toISOString(),
                ];
                
                $video->update([
                    'edited_path' => $outputPath,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to create trimmed video');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error trimming video: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add text overlay to video
     */
    public function addTextOverlay(int $videoId, array $options): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $outputFilename = time() . '_text_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Prepare text filter
            $text = str_replace(['\'', '"', ':', '\\'], ['\\\'', '\\"', '\\:', '\\\\'], $options['text']);
            $x = $options['x'];
            $y = $options['y'];
            $fontSize = $options['font_size'];
            $fontColor = $options['font_color'];
            
            $filter = "drawtext=text='$text':x=$x:y=$y:fontsize=$fontSize:fontcolor=$fontColor";
            
            // Add time constraints if specified
            if (isset($options['start_time'])) {
                $filter .= ":enable='between(t,{$options['start_time']}";
                if (isset($options['duration'])) {
                    $endTime = $options['start_time'] + $options['duration'];
                    $filter .= ",$endTime";
                }
                $filter .= ")'";
            }
            
            $cmd = "$ffmpeg -i \"$inputPath\" -vf \"$filter\" -codec:a copy \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullOutputPath)) {
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'add_text',
                    'params' => $options,
                    'timestamp' => now()->toISOString(),
                ];
                
                $video->update([
                    'edited_path' => $outputPath,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to add text overlay');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error adding text overlay: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Merge multiple videos
     */
    public function mergeVideos(array $videoIds): Video
    {
        $videos = Video::where('user_id', Auth::id())->whereIn('id', $videoIds)->get();
        
        if ($videos->count() < 2) {
            throw new \Exception('At least 2 videos are required for merging');
        }
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $userId = Auth::id();
            
            // Create a temporary concat file
            $concatFilename = time() . '_concat_' . Str::random(10) . '.txt';
            $concatPath = storage_path('app/public/videos/' . $userId . '/temp/' . $concatFilename);
            
            $dir = dirname($concatPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Write video paths to concat file
            $concatContent = '';
            foreach ($videos as $video) {
                $videoPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
                $concatContent .= "file '$videoPath'\n";
            }
            file_put_contents($concatPath, $concatContent);
            
            $outputFilename = time() . '_merged_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $userId . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Merge videos
            $cmd = "$ffmpeg -f concat -safe 0 -i \"$concatPath\" -c copy \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            // Clean up concat file
            @unlink($concatPath);
            
            if (file_exists($fullOutputPath)) {
                // Create new video record for merged video
                $firstVideo = $videos->first();
                $videoInfo = $this->getVideoInfo($fullOutputPath);
                
                $mergedVideo = Video::create([
                    'user_id' => $userId,
                    'title' => 'Merged Video - ' . now()->format('Y-m-d H:i:s'),
                    'original_filename' => $outputFilename,
                    'original_path' => $outputPath,
                    'edited_path' => $outputPath,
                    'duration' => $videoInfo['duration'] ?? null,
                    'width' => $videoInfo['width'] ?? $firstVideo->width,
                    'height' => $videoInfo['height'] ?? $firstVideo->height,
                    'file_size' => filesize($fullOutputPath),
                    'format' => $videoInfo['format'] ?? null,
                    'codec' => $videoInfo['codec'] ?? null,
                    'status' => 'completed',
                    'edit_history' => [
                        [
                            'action' => 'merge',
                            'params' => ['video_ids' => $videoIds],
                            'timestamp' => now()->toISOString(),
                        ]
                    ],
                ]);
                
                // Generate thumbnail
                $thumbnailPath = $this->generateThumbnail($fullOutputPath, $userId);
                if ($thumbnailPath) {
                    $mergedVideo->update(['thumbnail_path' => $thumbnailPath]);
                }
                
                return $mergedVideo;
            } else {
                throw new \Exception('Failed to merge videos');
            }
        } catch (\Exception $e) {
            Log::error('Error merging videos: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Apply filter to video
     */
    public function applyFilter(int $videoId, string $filter, float $intensity = 1.0): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $outputFilename = time() . '_filtered_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Define filter strings
            $filterString = match($filter) {
                'grayscale' => 'hue=s=0',
                'sepia' => 'colorchannelmixer=.393:.769:.189:0:.349:.686:.168:0:.272:.534:.131',
                'blur' => "boxblur=" . (5 * $intensity),
                'sharpen' => "unsharp=5:5:" . $intensity,
                'brightness' => "eq=brightness=" . ($intensity - 1),
                'contrast' => "eq=contrast=" . $intensity,
                'saturation' => "eq=saturation=" . $intensity,
                'negative' => 'negate',
                'vintage' => 'curves=vintage',
                default => throw new \Exception('Unknown filter type'),
            };
            
            $cmd = "$ffmpeg -i \"$inputPath\" -vf \"$filterString\" -codec:a copy \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullOutputPath)) {
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'apply_filter',
                    'params' => ['filter' => $filter, 'intensity' => $intensity],
                    'timestamp' => now()->toISOString(),
                ];
                
                $video->update([
                    'edited_path' => $outputPath,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to apply filter');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error applying filter: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Resize video
     */
    public function resizeVideo(int $videoId, int $width, int $height): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $outputFilename = time() . '_resized_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $cmd = "$ffmpeg -i \"$inputPath\" -vf scale=$width:$height -codec:a copy \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullOutputPath)) {
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'resize',
                    'params' => ['width' => $width, 'height' => $height],
                    'timestamp' => now()->toISOString(),
                ];
                
                $video->update([
                    'edited_path' => $outputPath,
                    'width' => $width,
                    'height' => $height,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to resize video');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error resizing video: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Rotate video
     */
    public function rotateVideo(int $videoId, int $angle): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $outputFilename = time() . '_rotated_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // FFmpeg rotation: 1=90°, 2=180°, 3=270° (clockwise)
            $transpose = match($angle) {
                90 => 1,
                180 => 2,
                270 => 3,
                default => throw new \Exception('Invalid rotation angle'),
            };
            
            $filter = $angle == 180 ? "transpose=1,transpose=1" : "transpose=$transpose";
            
            $cmd = "$ffmpeg -i \"$inputPath\" -vf \"$filter\" -codec:a copy \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullOutputPath)) {
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'rotate',
                    'params' => ['angle' => $angle],
                    'timestamp' => now()->toISOString(),
                ];
                
                // Swap width and height for 90° and 270° rotations
                $newWidth = ($angle == 90 || $angle == 270) ? $video->height : $video->width;
                $newHeight = ($angle == 90 || $angle == 270) ? $video->width : $video->height;
                
                $video->update([
                    'edited_path' => $outputPath,
                    'width' => $newWidth,
                    'height' => $newHeight,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to rotate video');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error rotating video: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Adjust video speed
     */
    public function adjustSpeed(int $videoId, float $speed): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $outputFilename = time() . '_speed_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);
            
            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $audioSpeed = $speed;
            $cmd = "$ffmpeg -i \"$inputPath\" -filter:v \"setpts=" . (1/$speed) . "*PTS\" -filter:a \"atempo=$audioSpeed\" \"$fullOutputPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullOutputPath)) {
                $editHistory = $video->edit_history ?? [];
                $editHistory[] = [
                    'action' => 'adjust_speed',
                    'params' => ['speed' => $speed],
                    'timestamp' => now()->toISOString(),
                ];
                
                $newDuration = (int) ($video->duration / $speed);
                
                $video->update([
                    'edited_path' => $outputPath,
                    'duration' => $newDuration,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to adjust video speed');
            }
            
            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error adjusting video speed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add audio to video
     */
    public function addAudio(int $videoId, UploadedFile $audioFile, float $volume = 1.0): Video
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        $video->update(['status' => 'processing']);

        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));

            // Store audio file temporarily
            $audioPath = $audioFile->store('videos/temp', 'public');
            $fullAudioPath = storage_path('app/public/' . $audioPath);

            $outputFilename = time() . '_audio_' . Str::random(10) . '.mp4';
            $outputPath = 'videos/' . $video->user_id . '/edited/' . $outputFilename;
            $fullOutputPath = storage_path('app/public/' . $outputPath);

            $dir = dirname($fullOutputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Add audio with volume adjustment
            $cmd = "$ffmpeg -i \"$inputPath\" -i \"$fullAudioPath\" -filter_complex \"[1:a]volume=$volume[a1];[0:a][a1]amix=inputs=2:duration=first\" -c:v copy \"$fullOutputPath\" 2>&1";
            $output = [];
            $returnVar = 0;
            exec($cmd . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('FFmpeg audio add failed: ' . implode("\n", $output));
            }

            // Clean up temporary audio file
            Storage::disk('public')->delete($audioPath);

            if (file_exists($fullOutputPath)) {
                $editHistory = is_array($video->edit_history) ? $video->edit_history : [];
                $editHistory[] = [
                    'action' => 'add_audio',
                    'params' => ['volume' => $volume],
                    'timestamp' => now()->toISOString(),
                ];

                $video->update([
                    'edited_path' => $outputPath,
                    'edit_history' => $editHistory,
                    'status' => 'completed',
                ]);
            } else {
                throw new \Exception('Failed to add audio: output file not created');
            }

            return $video->fresh();
        } catch (\Exception $e) {
            $video->update(['status' => 'failed']);
            Log::error('Error adding audio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Extract audio from video
     */
    public function extractAudio(int $videoId): string
    {
        $video = Video::where('user_id', Auth::id())->findOrFail($videoId);
        
        try {
            $ffmpeg = $this->getFFmpegPath();
            $inputPath = storage_path('app/public/' . ($video->edited_path ?? $video->original_path));
            
            $audioFilename = time() . '_audio_' . Str::random(10) . '.mp3';
            $audioPath = 'videos/' . $video->user_id . '/audio/' . $audioFilename;
            $fullAudioPath = storage_path('app/public/' . $audioPath);
            
            $dir = dirname($fullAudioPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $cmd = "$ffmpeg -i \"$inputPath\" -vn -acodec libmp3lame -q:a 2 \"$fullAudioPath\" 2>&1";
            shell_exec($cmd);
            
            if (file_exists($fullAudioPath)) {
                return $audioPath;
            } else {
                throw new \Exception('Failed to extract audio');
            }
        } catch (\Exception $e) {
            Log::error('Error extracting audio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get FFmpeg executable path
     */
    private function getFFmpegPath(): string
    {
        // Try common paths - prioritize user's installed version
        $paths = [
            'C:\laragon\bin\ffmpeg\ffmpeg-8.0-essentials_build\bin\ffmpeg.exe', // User's installed path
            'C:\laragon\bin\ffmpeg\ffmpeg-7.1-essentials_build\bin\ffmpeg.exe',
            'C:\ffmpeg\bin\ffmpeg.exe',
            '/usr/bin/ffmpeg',
            '/usr/local/bin/ffmpeg',
            'ffmpeg', // assumes it's in PATH
        ];

        foreach ($paths as $path) {
            if (file_exists($path) || $path === 'ffmpeg') {
                return $path;
            }
        }

        throw new \Exception('FFmpeg not found. Please install FFmpeg.');
    }

    /**
     * Get FFprobe executable path
     */
    private function getFFprobePath(): string
    {
        // Try common paths - prioritize user's installed version
        $paths = [
            'C:\laragon\bin\ffmpeg\ffmpeg-8.0-essentials_build\bin\ffprobe.exe', // User's installed path
            'C:\laragon\bin\ffmpeg\ffmpeg-7.1-essentials_build\bin\ffprobe.exe',
            'C:\ffmpeg\bin\ffprobe.exe',
            '/usr/bin/ffprobe',
            '/usr/local/bin/ffprobe',
            'ffprobe', // assumes it's in PATH
        ];

        foreach ($paths as $path) {
            if (file_exists($path) || $path === 'ffprobe') {
                return $path;
            }
        }

        throw new \Exception('FFprobe not found. Please install FFmpeg.');
    }
}
