<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ImageService
{
    /**
     * Generates a unique name for an image
     *
     * @param mixed $image
     *
     * @return String
     */
    public function buildName($image): String
    {
        return md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
    }

    /**
     * Returns an array of basic information about images
     *
     * @param Collection $images
     *
     * @return Array
     */
    public function getBasics(Collection $images): array
    {
        return $images->map(function ($image) {
            return [
                'name' => $image->filename,
                'size' => filesize(public_path("images/uploads/{$image->filename}")),
            ];
        })->toArray();
    }

    /**
     * Saves the request file
     *
     * @param mixed $request
     * @param String $name
     *
     * @return String
     */
    public function buildAndMove($request, String $name): String
    {
        $image = $request->file($name);
        $imageName = $this->buildName($image);
        $image->move(public_path('images/uploads'), $imageName);
        return $imageName;
    }
}
