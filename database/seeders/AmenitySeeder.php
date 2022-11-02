<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public $icons = [
        'Internet'                  => ['internet'          => ['en' => 'Internet',         'sr' => 'Internet']],
        'Kablovska'                 => ['cable'             => ['en' => 'Cable TV',         'sr' => 'Kablovska']],
        'Francuski krevet'          => ['bed-double'        => ['en' => 'Double bed',       'sr' => 'Francuski krevet']],
        'Krevet singl'              => ['bed-single'        => ['en' => 'Single bed',       'sr' => 'Krevet singl']],
        'Klima'                     => ['air-conditioner'   => ['en' => 'Air conditioning', 'sr' => 'Klima']],
        'Frižider'                  => ['fridge'            => ['en' => 'Fridge',           'sr' => 'Frižider']],
        'Zamrzivač'                 => ['freezer'           => ['en' => 'Freezer',          'sr' => 'Zamrzivač']],
        'Frižider sa zamrzivačem'   => ['big-fridge'        => ['en' => 'Refrigerator with freezer', 'sr' => 'Frižider sa zamrzivačem']],
        'Šporet'                    => ['stove'             => ['en' => 'Stove',            'sr' => 'Šporet']],
        'Rerna'                     => ['oven'              => ['en' => 'Oven',             'sr' => 'Rerna']],
        'Veš mašina'                => ['washing-machine'   => ['en' => 'Washing machine',  'sr' => 'Veš mašina']],
        'Tuš kabina'                => ['shower'            => ['en' => 'Shower cabin',     'sr' => 'Tuš kabina']],
        'Kada za kupanje'           => ['bathtub'           => ['en' => 'Bathtub',          'sr' => 'Kada za kupanje']],
        'Mašina za sudove'          => ['dishwasher'        => ['en' => 'Dishwasher',       'sr' => 'Mašina za sudove']],
        'tv'                        => ['tv'                => ['en' => 'TV',               'sr' => 'TV']],
        'Aspirator'                 => ['extractor-fan'     => ['en' => 'Extractor fan',    'sr' => 'Aspirator']],
        'Mikrotalasna'              => ['microwave'         => ['en' => 'Microwave',        'sr' => 'Mikrotalasna']],
        'Đakuzi'                    => ['jacuzzi'           => ['en' => 'Jacuzzi',          'sr' => 'Đakuzi']],
        'Telefon'                   => ['telephone'         => ['en' => 'Landline',         'sr' => 'Telefon']],
        'Mašina za sušenje veša'    => ['dryer'             => ['en' => 'Clothes dryer',    'sr' => 'Mašina za sušenje veša']],
        'Lift'                      => ['elevator'          => ['en' => 'Elevator',         'sr' => 'Lift']],
        'Bide'                      => ['bidet'             => ['en' => 'Bidet',            'sr' => 'Bide']],
        'Usisivač'                  => ['vacuum-cleaner'    => ['en' => 'Vacuum cleaner',   'sr' => 'Usisivač']],
        'Kamin'                     => ['fireplace'         => ['en' => 'Fireplace',        'sr' => 'Kamin']],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->icons as $name => $value) {
            $translation = head(array_values($value));

            $security = new Amenity();
            $security->icon = key($value);
            $security->name = $translation['sr'];
            $security->save();
        }
    }
}
