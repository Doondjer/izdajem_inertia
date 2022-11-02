<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_640_459 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(640, 459, function ($constraint){
            $constraint->upsize();
        });
    }
}