<?php

namespace App\Http\Controllers;

use App\ImageUpload;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ImageUploadController extends Controller
{
    /**
     * Returns the view to add an image
     *
     * @return View
     */
    public function fileCreate(): View
    {
        return view('imageupload');
    }

    /**
     * Stores a new image
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function fileStore(Request $request, ImageService $imageService): JsonResponse
    {
        $imageName = $imageService->buildAndMove($request, 'file');

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->original_name = $request->file('file')->getClientOriginalName();
        $imageUpload->owner_id = \Auth::id();
        $imageUpload->save();

        return response()->json(['success' => $imageName]);
    }

    /**
     * Destroys a file
     *
     * @param Request $request
     *
     * @return String
     */
    public function fileDestroy(Request $request): String
    {
        $filename = $request->get('filename');
        $image = ImageUpload::where('filename', $filename)
            ->orWhere('original_name', $filename);

        if (!\Auth::user()->is_admin) {
            $image->where('owner_id', \Auth::id());
        }

        $image->delete();

        $path = public_path() . '/images/uploads' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
