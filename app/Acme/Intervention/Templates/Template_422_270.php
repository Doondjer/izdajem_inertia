<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_422_270 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(422, 270, function ($constraint){
            $constraint->upsize();
        });
    }
}