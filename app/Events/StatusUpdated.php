<?php

namespace App\Events;

use App\Models\ListingStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var ListingStatus|null */
    public $oldStatus;

    /** @var ListingStatus */
    public $newStatus;

    public function __construct(?ListingStatus $oldStatus, ListingStatus $newStatus)
    {
        $this->oldStatus = $oldStatus;

        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
