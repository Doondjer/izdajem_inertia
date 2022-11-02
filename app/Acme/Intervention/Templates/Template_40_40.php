<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_40_40 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(40, 40, function ($constraint){
            $constraint->upsize();
        });
    }
}
