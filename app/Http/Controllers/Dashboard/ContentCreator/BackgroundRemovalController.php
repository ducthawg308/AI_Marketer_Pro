<?php

namespace App\Http\Controllers\Dashboard\ContentCreator;

use App\Services\Dashboard\ContentCreator\RemoveBgService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackgroundRemovalController extends Controller
{
    protected $removeBgService;

    public function __construct(RemoveBgService $removeBgService)
    {
        $this->removeBgService = $removeBgService;
    }

    public function index()
    {
        return view('dashboard.content_creator.remove_bg.index');
    }

    /**
     * Xử lý và trả về ảnh dạng base64
     */
    public function remove(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:12288',
        ]);

        try {
            // Xóa phông nền
            $processedImageData = $this->removeBgService->removeBackground($request->file('image'));

            // Chuyển sang base64 để trả về browser
            $base64Image = base64_encode($processedImageData);

            return response()->json([
                'success' => true,
                'message' => 'Background removed successfully!',
                'processed_image' => 'data:image/png;base64,' . $base64Image,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tải xuống ảnh đã xử lý (fallback route nếu cần)
     */
    public function download($filename)
    {
        try {
            $filePath = storage_path('app/' . $filename);

            if (!file_exists($filePath)) {
                abort(404, 'File not found');
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            abort(500, 'Download failed');
        }
    }
}
