<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Amenity;
use App\Models\Bookmark;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Security;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'name' => 'Predrag Markovic',
            'email' => 'predrag.t.markovic@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'admin_since' => Carbon::now(),
            'phone' => '38163378616'
        ]);
        $user = User::factory()->create([
            'name' => 'Gost',
            'email' => 'pusic.antonije@gmail.com',
            'email_verified_at' => now(),
            'password' => 'ne-treba-lozinka-za-pristup',
        ]);

        $users = User::factory(50)->create();

        $this->call(SecuritySeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(AmenitySeeder::class);

        $adminListings = Listing::factory(30)->create(['user_id' => $admin->id]);

        foreach ($users as $user) {
            $userListings = Listing::factory(10)->create(['user_id' => $user->id]);
        }
        $listings = Listing::all();

        foreach ($users as $user) {
            foreach ($listings->random(rand(0,15)) as $item) {
                Bookmark::factory()->create([
                    'user_id' => $user->id,
                    'listing_id' => $item->id
                ]);
            }
        }

        $userListings->random(10)->each(function ($listing) use ($admin){
            Bookmark::factory()->create([
                'user_id' => $admin->id,
                'listing_id' => $listing->id
            ]);
        });

        $adminListings->each(function ($listing) use ($users) {
            Image::factory(rand(1,5))->create(['listing_id' => $listing->id]);

            $amenities  = Amenity::inRandomOrder()->take(rand(0, Amenity::all()->count()))->get();
            $securities  = Security::inRandomOrder()->take(rand(0, Security::all()->count()))->get();
            $listing->amenities()->sync($amenities);
            $listing->securities()->sync($securities);

            $thread = Thread::factory()->create(['listing_id' => $listing->id]);
            $thread->messages()->create(['user_id' => 1,'body' => 'ddddddddddddddddddddddddddddddddddddddd']);

            $thread->participants()->create(['user_id' => 1, 'read_at' => Carbon::now()]);
            $thread->participants()->create(['user_id' => 2]);
        });


        $userListings->each(function ($listing) {
            Image::factory(rand(1,5))->create(['listing_id' => $listing->id]);

            $amenities  = Amenity::inRandomOrder()->take(rand(0, Amenity::all()->count()))->get();
            $securities  = Security::inRandomOrder()->take(rand(0, Security::all()->count()))->get();
            $listing->amenities()->sync($amenities);
            $listing->securities()->sync($securities);


        });
    }
}
