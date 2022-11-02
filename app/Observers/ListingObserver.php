<?php

namespace App\Observers;

use App\Acme\Traits\AggregateTrait;
use App\Jobs\UpdateListingSitemap;
use App\Mail\ListingCreated;
use App\Models\Listing;
use App\Notifications\ListingWasCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class ListingObserver
{
    use AggregateTrait;

    public function saved(Listing $listing)
    {
        $this->updateSitemap();
        $this->reAggregate();
    }

    public function created(Listing $listing)
    {
        $listing->setStatusTo('created', "User " . Auth::id() . ' je napravio nov oglas');
    }

    public function updating(Listing $listing)
    {
        $listing->youtube_id = $listing->video_url;
    }

    public function updated(Listing $listing)
    {
        if( ! App::environment('local')) {

            try {

                if ($listing->getOriginal('status') !== 'published' && $listing->status === 'published') {
                    if (
                        $listing->user
                        && $listing->user->id === Auth::user()->id
                        && $listing->user->email
                        && $listing->user->email_notify_listing_created
                    ) {
                        Mail::to($listing->user->email)->send(new ListingCreated($listing));
                    }
                }

                /*if ($listing->getOriginal('published_at') === null && $listing->isDirty('published_at') && config('app_settings.values.published_listing_to_twitter')) {

                    Log::info("Listing $listing->slug was created");
                    Log::info("Listing original published_at : " . $listing->getOriginal('published_at'));
                    Log::info("Listing published_at was changed? " . $listing->wasChanged('published_at'));
                    Log::info("Listing actual published_at : $listing->published_at");

                    $listing->syncOriginalAttribute('published_at');

                    $delay = now()->addMinutes(10);
                    $listing->notify((new ListingWasCreated())->delay($delay));
                }*/

            } catch (\Exception $e) {

                report($e);
            }
        }
    }

    public function deleted(Listing $listing)
    {
        $this->updateSitemap();
        $this->reAggregate();
    }

    public function restored(Listing $listing)
    {
        $this->updateSitemap();
        $this->reAggregate();
    }

    public function updateSitemap()
    {
        try {
            $lock = Cache::lock('listingSitemap', 2 * 60 * 60);

            if($lock->get()) {

                $delay = now()->addHours(2);
             //   $delay = now()->addMinutes(2);

                UpdateListingSitemap::dispatch()->delay($delay);
            }

        } catch (\Exception $e) {

            report($e);
        }
    }
}
