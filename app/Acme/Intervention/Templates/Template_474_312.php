<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_474_312 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(474, 312, function ($constraint){
            $constraint->upsize();
        });
    }
}