<?php

namespace Database\Seeders;

use App\Models\Security;
use Illuminate\Database\Seeder;

class SecuritySeeder extends Seeder
{
    public $icons = [
        'Alarm'                         => ['alarm'     => ['en' => 'Alarm',                'sr' => 'Alarm']],
        'Interfon'                      => ['intercom'  => ['en' => 'Intercom',             'sr' => 'Interfon']],
        'Kamere'                        => ['cameras'   => ['en' => 'Cameras',              'sr' => 'Kamere']],
        'Obezbeđenje'                   => ['security'  => ['en' => 'Security',             'sr' => 'Obezbeđenje']],
        'Rampa za invalidska kolica'    => ['ramp'      => ['en' => 'Wheelchair access',    'sr' => 'Rampa za invalidska kolica']],
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

            $security = new Security();
            $security->icon = key($value);
            $security->name = $translation['sr'];
            $security->save();
        }
    }
}
