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

    public function getBasics(Collection $images)
    {
        return $images->map(function ($image) {
            return [
                'name' => $image->filename,
                'size' => filesize(public_path("images/uploads/{$image->filename}")),
            ];
        })->toArray();
    }
}
