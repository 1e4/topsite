<?php

namespace App\Http\Controllers;

use App\ImageUpload;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function fileCreate()
    {
        return view('imageupload');
    }

    public function fileStore(Request $request)
    {
        $image = $request->file('file');
        $imageName = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->original_name = $image->getClientOriginalName();
        $imageUpload->owner_id = \Auth::user()->id;
        $imageUpload->save();

        return response()->json(['success' => $imageName]);
    }

    public function fileDestroy(Request $request)
    {
        $filename = $request->get('filename');
        $image = ImageUpload::where('filename', $filename)
            ->orWhere('original_name', $filename);

        if (!\Auth::user()->is_admin) {
            $image->where('owner_id', \Auth::user()->id);
        }

        $image->delete();

        $path = public_path() . '/images/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
