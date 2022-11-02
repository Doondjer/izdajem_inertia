<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $paragraphs = $this->faker->paragraphs(rand(2, 6));
        $title = $this->faker->realText(50);
        $description = "<strong>{$title}</strong>";
        foreach ($paragraphs as $para) {
            $description .= "<p>{$para}</p>";
        }

        $addresses = json_decode(file_get_contents('database/factories/addresses.json'), true);
        $address = $this->faker->randomElement($addresses);

        return [
            'street' => Arr::get($address,'street',$this->faker->streetName),
            'street_nb' => Arr::get($address,'street_nb'),
            'latitude' => Arr::get($address,'latitude', '44.7000000'),//$this->faker->address()->latitude,//'44.7000000',//$this->faker->latitude(44.70000, 44.80000),
            'longitude' => Arr::get($address,'longitude', '20.0000000'),//$this->faker->address()->longitude,//'20.0000000',//$this->faker->longitude(20.30000, 20.40000),
            'county' => Arr::get($address,'county','Grad Beograd'),
            'district' => Arr::get($address,'district','Zemun'),
            'city' => Arr::get($address,'city', 'Beograd'),
            'country' => Arr::get($address,'country', 'Srbija'),
            'location_id' => Arr::get($address,'location_id'),
            'nb_room' => (string) $this->faker->randomElement(array_keys(config('app_settings.values.structure'))),
            'description' => $description,
            'type' => $this->faker->randomElement(array_keys(config('app_settings.values.types'))),
            'furnish_type' => $this->faker->randomElement(array_keys(config('app_settings.values.furnish_types'))),
            'available_from' => $this->faker->date(),
            'pets_allowed' => (boolean)rand(0,1),
            // 'pets_allowed'      => json_encode(''),
            'price' => $price = $this->faker->numberBetween(50, 500),
            'deposit' => $price,
            'currency' => 'EUR',
            'total_floor' => $totalFloor = $this->faker->numberBetween(1, 20),
            'nb_floor' => $this->faker->numberBetween(0, $totalFloor),
            'size' => $this->faker->numberBetween(20, 100),
            'status' => $this->faker->boolean(70) ? 'published' : 'draft',
            'status_updated_at' => Carbon::now(),
            'video_url' => rand(0,1) ? $this->faker->randomElement([
                'https://youtu.be/ENNNAab7IJY',
                'https://youtu.be/XykR_UH1hZ0',
                'https://youtu.be/MlnrDKjeWGM',
                'https://youtu.be/cqnFi1R57sY',
                'https://youtu.be/bVF3P8tctNc'
            ]) : null,
            'user_id' => User::factory()
        ];
    }
}
