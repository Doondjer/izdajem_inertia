<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_resize_236 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->resize(236, null, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}