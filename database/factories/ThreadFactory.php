<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'listing_id' => $listing = Listing::factory()->create(),
            'type' => 'private',
            'subject' => $listing->title,
        ];
    }
}
