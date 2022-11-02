<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_32_32 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(32, 32, function ($constraint){
            $constraint->upsize();
        });
    }
}
