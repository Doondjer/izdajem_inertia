<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_75_75 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(75, 75, function ($constraint){
            $constraint->upsize();
        });
    }
}