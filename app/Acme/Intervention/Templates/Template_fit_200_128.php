<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_fit_200_128 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(200, 128, function ($constraint){
          //  $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}
