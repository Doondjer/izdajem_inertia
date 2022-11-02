<?php

namespace App\Console\Commands;

use App\Models\Amenity;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Page;
use App\Models\Security;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncDatabasesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy and convert data from listings database to rent database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $serverUsers = User::on('mysql_temp')->withTrashed()->orderBy('id')->get();
        User::withoutEvents(function () use ($serverUsers){
            foreach ($serverUsers as $serverUser) {
                $user = new User();
                $user->forceCreate([
                    'id' => $serverUser->id,
                    'name' => $serverUser->name,
                    'email' => $serverUser->email,
                    'email_verified_at' => $serverUser->email_verified_at,
                    'password' => $serverUser->password,
                    'twitter' => $serverUser->twitter,
                    'facebook' => $serverUser->facebook,
                    'instagram' => $serverUser->instagram,
                    'admin_since' => $serverUser->is_admin ? Carbon::now() : null,
                    'email_notify_message_sent' => $serverUser->email_notify_message_sent,
                    'email_notify_message_received' => $serverUser->email_notify_message_received,
                    'email_notify_listing_created' => $serverUser->email_notify_listing_created,
                    'sms_notify_message_received' => $serverUser->sms_notify_message_received,
                    'current_team_id' => $serverUser->current_team_id,
                    'profile_photo_path' => $serverUser->profile_image,
                    'phone' => $serverUser->phone,
                    'phone_raw' => $serverUser->phone_raw,
                    'phone_verified_at' => $serverUser->phone_verified_at,
                    'created_at' => $serverUser->created_at,
                    'updated_at' => $serverUser->updated_at,
                    'deleted_at' => $serverUser->deleted_at,

                ]);
           }
        });

        $this->comment('Users copied!');

        $serverSocials = SocialAccount::on('mysql_temp')->orderBy('id')->get();

        SocialAccount::withoutEvents(function () use ($serverSocials) {
            foreach ($serverSocials as $serverSocial) {
                SocialAccount::forceCreate([
                    'id' => $serverSocial->id,
                    'user_id' => $serverSocial->user_id,
                    'name' => $serverSocial->name,
                    'nickname' => $serverSocial->nickname,
                    'email' => $serverSocial->email,
                    'telephone' => $serverSocial->telephone,
                    'provider' => $serverSocial->provider,
                    'provider_user_id' => $serverSocial->provider_user_id,
                    'avatar' => $serverSocial->avatar,
                    'access_token' => $serverSocial->access_token,
                    'refresh_token' => $serverSocial->refresh_token,
                    'expires_in' => $serverSocial->expires_in,
                    'created_at' => $serverSocial->created_at,
                    'updated_at' => $serverSocial->updated_at,
                ]);
            }
        });

        $this->comment('Social accounts copied!');


        $serverSecurities = Security::on('mysql_temp')->orderBy('id')->get();

        Security::withoutEvents(function ()use ($serverSecurities){
            foreach ($serverSecurities as $serverSecurity) {
                Security::forceCreate([
                    'id' => $serverSecurity->id,
                    'name' => json_decode($serverSecurity->name)->sr,
                    'icon' => $serverSecurity->icon,
                    'created_at' => $serverSecurity->created_at,
                    'updated_at' => $serverSecurity->updated_at,
                ]);
            }
        });

        $this->comment('Securities copied!');


        $serverAmenities = Amenity::on('mysql_temp')->orderBy('id')->get();

        Amenity::withoutEvents(function ()use ($serverAmenities){
            foreach ($serverAmenities as $serverAmenity) {
                Amenity::forceCreate([
                    'id' => $serverAmenity->id,
                    'name' => json_decode($serverAmenity->name)->sr,
                    'icon' => $serverAmenity->icon,
                    'created_at' => $serverAmenity->created_at,
                    'updated_at' => $serverAmenity->updated_at,
                ]);
            }
        });

        $this->comment('Amenities copied!');


        $serverPages = Page::on('mysql_temp')->orderBy('id')->get();

        Page::withoutEvents(function ()use ($serverPages){
            foreach ($serverPages as $serverPage) {
                Page::forceCreate([
                    'id' => $serverPage->id,
                    'slug' => $serverPage->slug,
                    'title' => $serverPage->title,
                    'meta_title' => $serverPage->meta_title,
                    'size' => $serverPage->size,
                    'classes' => $serverPage->classes,
                    'meta_description' => $serverPage->meta_description,
                    'meta_keywords' => $serverPage->meta_keywords,
                    'content' => $serverPage->content,
                    'created_at' => $serverPage->created_at,
                    'updated_at' => $serverPage->updated_at,
                ]);
            }
        });

        $this->comment('Pages copied!');


        $serverlistings = Listing::on('mysql_temp')->withTrashed()->orderBy('id')->get();

        Listing::withoutEvents(function () use ($serverlistings) {
            foreach ($serverlistings as $serverlisting) {
                if ($serverlisting->type == 2) {
                    $type = 'kuca';
                } elseif ($serverlisting->type == 3) {
                    $type = 'stan-u-kuci';
                } elseif ($serverlisting->type == 6 || $serverlisting->type == 4) {
                    $type = 'poslovni-prostor';
                } else {
                    $type = 'stan';
                }
                if ($serverlisting->furnish_type == 1) {
                    $furnishType = 'namesten';
                } elseif ($serverlisting->type == 2) {
                    $furnishType = 'polunamesten';
                } else {
                    $furnishType = 'nenamesten';
                }

                Listing::forceCreate([
                    'id' => $serverlisting->id,
                    'slug' => json_decode($serverlisting->slug)->sr,
                    'description' => $serverlisting->description,
                    'street' => $serverlisting->street,
                    'street_nb' => $serverlisting->street_nb,
                    'city' => $serverlisting->city,
                    'county' => $serverlisting->county,
                    'country' => 'Srbija',
                    'district' => $serverlisting->district,
                    'postal_code' => $serverlisting->postal_code,
                    'type' => $type,
                    'video_url' => $serverlisting->video_url,
                    'nb_room' => $serverlisting->nb_room,
                    'longitude' => $serverlisting->longitude,
                    'latitude' => $serverlisting->latitude,
                    'location_id' => $serverlisting->location_id,
                    'furnish_type' => $furnishType,
                    'available_from' => $serverlisting->available_from,
                    'pets_allowed' => $serverlisting->pets_allowed,
                    'price' => $serverlisting->price,
                    'deposit' => $serverlisting->deposit,
                    'currency' => $serverlisting->currency,
                    'total_floor' => $serverlisting->total_floor,
                    'nb_floor' => $serverlisting->nb_floor,
                    'size' => $serverlisting->size,
                    'user_id' => $serverlisting->user_id,
                    'phone' => $serverlisting->phone,
                    'status' => $serverlisting->rented_at ? 'rented' : 'draft',
                    'status_updated_at' => $serverlisting->created_at,
                    'source_url' => $serverlisting->source_url,
                    'created_at' => $serverlisting->created_at,
                    'updated_at' => $serverlisting->updated_at,
                    'deleted_at' => $serverlisting->deleted_at,
                ]);
            }
        });


        $this->comment('Listings copied!');



        $serverListingSecurities = \DB::connection('mysql_temp')->table('listing_security')->orderBy('id')->get();

            foreach ($serverListingSecurities as $serverListingSecurity) {
                \DB::table('listing_security')->insert([
                    'id' => $serverListingSecurity->id,
                    'listing_id' => $serverListingSecurity->listing_id,
                    'security_id' => $serverListingSecurity->security_id,
                    'created_at' => $serverListingSecurity->created_at,
                    'updated_at' => $serverListingSecurity->updated_at,
                ]);
            };


        $this->comment('listing_security copied!');


        $serverListingAmenities = \DB::connection('mysql_temp')->table('amenity_listing')->orderBy('id')->get();


            foreach ($serverListingAmenities as $serverListingAmenity) {
                \DB::table('amenity_listing')->insert([
                    'id' => $serverListingAmenity->id,
                    'listing_id' => $serverListingAmenity->listing_id,
                    'amenity_id' => $serverListingAmenity->amenity_id,
                    'created_at' => $serverListingAmenity->created_at,
                    'updated_at' => $serverListingAmenity->updated_at,
                ]);
            };



        $this->comment('amenity_listing copied!');


        $serverImages = Image::on('mysql_temp')->whereNotNull('listing_id')->orderBy('id')->get();

        Image::withoutEvents(function ()use ($serverImages){
            foreach ($serverImages as $serverImage) {
                Image::forceCreate([
                    'id' => $serverImage->id,
                    'filename' => $serverImage->filename,
                    'webp_filename' => $serverImage->webp_filename,
                    'mime' => $serverImage->mime,
                    'original_filename' => $serverImage->original_filename,
                    'size' => $serverImage->size,
                    'listing_id' => $serverImage->listing_id,
                    'created_at' => $serverImage->created_at,
                    'updated_at' => $serverImage->updated_at,
                ]);
            }
        });

        $this->comment('Images copied!');


    }
}
