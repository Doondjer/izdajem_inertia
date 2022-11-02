<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    |
    | {route}/{template}/{filename}
    |
    | Examples: "images", "img/cache"
    |
    */

    'route' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submitted
    | by URI.
    |
    | Define as many directories as you like.
    |
    */

    'paths' => [
        public_path('upload'),
        public_path('images'),
        public_path('image'),
        storage_path('images'),
        storage_path('images/webp'),
        storage_path('images/phones'),
        storage_path('app/public'),
        storage_path('images/users'),
        storage_path('images/blueprint'),
       // '~/code/izdavanje/storage/images/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */

    'templates' => [
        'small'     => 'Intervention\Image\Templates\Small',
        'medium'    => \App\Acme\Intervention\Templates\Medium::class,
        'large'     => 'Intervention\Image\Templates\Large',
        '1024x768'  => 'App\Acme\Intervention\Templates\Template_1024_768',
        'gallery'   => \App\Acme\Intervention\Templates\Template_1080::class,
        'blueprint' => \App\Acme\Intervention\Templates\Template_resize_470::class,
        '236x236'   => \App\Acme\Intervention\Templates\Template_resize_236::class,
        '200'       => \App\Acme\Intervention\Templates\Template_fit_200_128::class,
        '300'       => \App\Acme\Intervention\Templates\Template_resize_300::class,
        '350'       => \App\Acme\Intervention\Templates\Template_fit_350_224::class,
        '370'       => \App\Acme\Intervention\Templates\Template_resize_370::class,
        '500'       => \App\Acme\Intervention\Templates\Template_resize_500::class,
        '596'       => \App\Acme\Intervention\Templates\Template_resize_596::class,
        '800'       => \App\Acme\Intervention\Templates\Template_resize_800::class,
        '640x459'   => \App\Acme\Intervention\Templates\Template_640_459::class,
        '422x270'   => \App\Acme\Intervention\Templates\Template_422_270::class,
        '75x75'     => \App\Acme\Intervention\Templates\Template_75_75::class,
        '32x32'     => \App\Acme\Intervention\Templates\Template_32_32::class,
        '40x40'     => \App\Acme\Intervention\Templates\Template_40_40::class,
        '474x312'   => \App\Acme\Intervention\Templates\Template_474_312::class,
        'original'  => \Acme\Intervention\Templates\Original::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */

    'lifetime' => 60*24*30*6,//43200,

];
