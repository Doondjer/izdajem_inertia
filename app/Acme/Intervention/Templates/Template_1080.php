<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_1080 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->resize(null, 1080, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}