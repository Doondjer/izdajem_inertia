<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Intervention;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $filepath = storage_path('images');

        if(!File::exists($filepath)){
            File::makeDirectory($filepath);
        }

        $image = Intervention::make(Storage::disk('local')->path(
            $this->faker->randomElement(Storage::disk('local')->files('seed'))
        ));

        $filename = Str::orderedUuid()->toString();
        Storage::disk('images')->put("$filename.jpg",$image->encode('jpg'));
        Storage::disk('images')->put("webp/$filename.webp",$image->encode('webp'));

        return [
            'filename' => "$filename.jpg",
            'webp_filename' => "$filename.webp",
            'mime'      => 'jpg',
            'original_filename' => $this->faker->name,
            'listing_id' => Listing::factory()
        ];
    }
}
