<?php

namespace App\Acme\Intervention\Templates;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class Template_fit_350_224 implements FilterInterface
{

    public function applyFilter(Image $image)
    {

        return $image->fit(350, 224, function ($constraint){
          //  $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}
