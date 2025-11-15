<?php

namespace App\Http\Controllers\Dashboard\ContentCreator;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\ContentCreator\Video;
use App\Services\Dashboard\ContentCreator\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function __construct(private VideoService $videoService) {}

    /**
     * Get all videos for the authenticated user
     */
    public function index(): JsonResponse
    {
        $videos = Video::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'videos' => $videos
        ]);
    }

    /**
     * Upload a new video
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|file|mimes:mp4,avi,mov,wmv,flv,mkv,webm|max:512000', // max 500MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->uploadVideo($request->file('video'), [
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get video details
     */
    public function show($id): JsonResponse
    {
        $video = Video::where('user_id', Auth::id())->find($id);

        if (!$video) {
            return response()->json([
                'success' => false,
                'message' => 'Video not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'video' => $video
        ]);
    }

    /**
     * Trim/Cut video
     */
    public function trim(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|numeric|min:0',
            'end_time' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->trimVideo($id, $request->start_time, $request->end_time);

            return response()->json([
                'success' => true,
                'message' => 'Video trimmed successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to trim video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add text overlay to video
     */
    public function addText(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'x' => 'required|integer|min:0',
            'y' => 'required|integer|min:0',
            'font_size' => 'nullable|integer|min:10|max:200',
            'font_color' => 'nullable|string',
            'start_time' => 'nullable|numeric|min:0',
            'duration' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->addTextOverlay($id, [
                'text' => $request->text,
                'x' => $request->x,
                'y' => $request->y,
                'font_size' => $request->font_size ?? 24,
                'font_color' => $request->font_color ?? 'white',
                'start_time' => $request->start_time ?? 0,
                'duration' => $request->duration,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Text added successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add text: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Merge/Concatenate videos
     */
    public function merge(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'video_ids' => 'required|array|min:2',
            'video_ids.*' => 'required|integer|exists:videos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->mergeVideos($request->video_ids);

            return response()->json([
                'success' => true,
                'message' => 'Videos merged successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to merge videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply filter to video
     */
    public function applyFilter(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'filter' => 'required|string|in:grayscale,sepia,blur,sharpen,brightness,contrast,saturation,negative,vintage',
            'intensity' => 'nullable|numeric|min:0|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->applyFilter($id, $request->filter, $request->intensity ?? 1);

            return response()->json([
                'success' => true,
                'message' => 'Filter applied successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply filter: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resize video
     */
    public function resize(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'width' => 'required|integer|min:1|max:7680',
            'height' => 'required|integer|min:1|max:4320',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->resizeVideo($id, $request->width, $request->height);

            return response()->json([
                'success' => true,
                'message' => 'Video resized successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resize video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rotate video
     */
    public function rotate(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'angle' => 'required|integer|in:90,180,270',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->rotateVideo($id, $request->angle);

            return response()->json([
                'success' => true,
                'message' => 'Video rotated successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to rotate video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Adjust video speed
     */
    public function adjustSpeed(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'speed' => 'required|numeric|min:0.25|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->adjustSpeed($id, $request->speed);

            return response()->json([
                'success' => true,
                'message' => 'Video speed adjusted successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to adjust speed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add audio to video
     */
    public function addAudio(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audio' => 'required|file|mimes:mp3,wav,aac,m4a|max:51200', // max 50MB
            'volume' => 'nullable|numeric|min:0|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = $this->videoService->addAudio($id, $request->file('audio'), $request->volume ?? 1);

            return response()->json([
                'success' => true,
                'message' => 'Audio added successfully',
                'video' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add audio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract audio from video
     */
    public function extractAudio($id): JsonResponse
    {
        try {
            $audioPath = $this->videoService->extractAudio($id);

            return response()->json([
                'success' => true,
                'message' => 'Audio extracted successfully',
                'audio_url' => asset('storage/' . $audioPath)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to extract audio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download video
     */
    public function download($id)
    {
        $video = Video::where('user_id', Auth::id())->find($id);

        if (!$video) {
            abort(404, 'Video not found');
        }

        $path = $video->edited_path ?? $video->original_path;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Video file not found');
        }

        return Storage::disk('public')->download($path, $video->original_filename);
    }

    /**
     * Delete video
     */
    public function destroy($id): JsonResponse
    {
        try {
            $video = Video::where('user_id', Auth::id())->find($id);

            if (!$video) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video not found'
                ], 404);
            }

            // Delete files
            if (Storage::disk('public')->exists($video->original_path)) {
                Storage::disk('public')->delete($video->original_path);
            }

            if ($video->edited_path && Storage::disk('public')->exists($video->edited_path)) {
                Storage::disk('public')->delete($video->edited_path);
            }

            if ($video->thumbnail_path && Storage::disk('public')->exists($video->thumbnail_path)) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }

            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete video: ' . $e->getMessage()
            ], 500);
        }
    }
}
