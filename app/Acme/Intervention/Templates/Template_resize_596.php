<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_resize_596 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->resize(596, null, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}
