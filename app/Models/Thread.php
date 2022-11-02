<?php

namespace App\Models;

use App\Events\MessageReceived;
use App\Events\NbMessages;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject',
        'listing_id',
        'type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get listing from this thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing() {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get messages for this thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all participants in this thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class)->withTrashed();
    }

    /**
     * Get all unread messages...
     * Use with App\Model\User::threads()->unread
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query)
    {
        return $query->where('participants.user_id', Auth::id())
            ->whereNull('participants.deleted_at')
            ->where(function ($query) {
                $query->where('threads.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . 'participants.read_at'))
                    ->orWhereNull('participants.read_at');
            })
            ->select('threads.*')->with('messages.participants');
    }

    /**
     * Make authenticated user read current thread
     *
     * @return mixed
     */
    public function readByAuth()
    {
        return $this->readBy(Auth::user());
    }

    /**
     * Read thread by this user
     *
     * @param User $user| Auth $user
     * @return mixed
     */
    public function readBy(User $user)
    {
        return $this->participants()
            ->whereUserId($user->id)
            ->update(['read_at' => Carbon::now()]);
    }

    /**
     * Add Participant and make thread as read if necessary
     *
     * @param User $user
     * @param bool $readThread
     * @return Model
     */
    public function addParticipant(User $user, $readThread = false)
    {
        $participant = $this->participants()->firstOrCreate(['user_id'   => $user->id]);

        if($readThread) {
            $participant->update(['read_at' => Carbon::now()]);
        }

        return $participant;

    }

    /**
     * Check if authenticated user participate in this thread
     *
     * @return mixed
     */
    public function isAuthParticipant()
    {
        return $this->isUserParticipant(Auth::user());
    }

    /**
     * Check if user participate in this thread
     * N + 1 Problem
     *
     * @param User $user| Auth $user
     * @return mixed
     */
    public function isUserParticipant(User $user)
    {
        return $this->participants()->whereUserId($user->id)->count();
    }

    /**
     * Set all participants did not read thread
     *
     * @return int
     */
    public function unreadParticipants()
    {
        return $this->participants()->update(['read_at' => null]);
    }

    /**
     * Restore soft deleted participants for this thread
     *
     * @return mixed
     */
    public function restoreAllParticipants()
    {
        return $this->participants()->withTrashed()->restore();
    }

    /**
     * Create new reply for current thread
     *
     * @param string $message
     * @param User $sender
     * @return $this
     */
    public function sendReply(string $message, User $sender)
    {
        $this->restoreAllParticipants();


        $this->messages()->create([
            'user_id'   => $sender->id,
            'body'      => $message,
        ]);

        $this->unreadParticipants();
        $this->addParticipant($sender, true);


        if($recipients = $this->participants->where('user_id', '!=', $sender->id)) {
            foreach ($recipients as $recipient) {

                MessageReceived::dispatch($this, $recipient->user_id);
                NbMessages::dispatch(Participant::unread($recipient->user_id)->count(), $recipient->user_id);
            }
        }

        return $this;
    }

    /**
     * Create initial, first message for current thread
     *
     * @param string $message
     * @param User $sender
     * @param User $recipient
     * @return $this
     */
    public function sendInitialMessage(string $message, User $sender, User $recipient)
    {
        $this->addParticipant($sender, true);
        $this->addParticipant($recipient);

        $this->messages()->create([
            'user_id'   => $sender->id,
            'body'      => $message,
        ]);


        MessageReceived::dispatch($this, $recipient->id);
        NbMessages::dispatch(Participant::unread($recipient->user_id)->count(), $recipient->user_id);

        return $this;
    }
}
