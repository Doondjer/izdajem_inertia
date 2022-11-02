<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['thread'];

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = [
        'thread_id',
        'user_id',
        'body',
        'send'
    ];

    protected $dates = [
        'created_at'
    ];
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'body' => 'required',
    ];

    /**
     * Thread relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * User relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Participants relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class, 'thread_id', 'thread_id')->withTrashed();
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
        return $query->whereNull('participants.read_at')
            ->with(['messages.participants' => function($query){
                return $query->whereNull('read_at')->whereUserId(Auth::id());
            }]);
    }

    /**
     * Recipients of this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->participants()->where('user_id', '!=', $this->user_id);
    }

    /**
     * Mutator display when message created in human readable format
     *
     * @return mixed
     */
    public function getCreatedHumanAttribute() {

        return $this->created_at->diffForHumans();
    }

    /**
     * Check if Authenticated user has sent this message
     *
     * @return bool
     */
    public function isSenderAuthAttribute()
    {
        return $this->user_id == Auth::id();
    }
}
