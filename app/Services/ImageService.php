<?php

namespace App\Services;

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
}
