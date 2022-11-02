<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_1024_768 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(1024, 768, function ($constraint){
            $constraint->upsize();
        });
    }
}