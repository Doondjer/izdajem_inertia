<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Listing;

class ListingCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $listing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Postavljen je novi oglas - " . $this->listing->title)
                    ->view('emails.listing.new');
    }
}
