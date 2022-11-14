<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'phone_raw',
        'phone_verified_at',
        'email',
        'password',
        'email_notify_message_sent',
        'email_notify_message_received',
        'email_notify_listing_created',
        'sms_notify_message_received',
        'show_profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = 'https://example.com/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get all listings associated with this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Get all Message Threads for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function threads()
    {
        return $this->hasManyThrough(Thread::class, Participant::class, 'user_id','id','id', 'thread_id' )->orderBy('updated_at', 'desc');
    }

    /**
     * Get all bookmarks for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * get users Social Accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (bool) $this->admin_since;
    }

    /**
     * Check if user has verified phone
     *
     * @return bool
     */
    public function isPhoneVerified()
    {
        return $this->phone && $this->phone_verified_at;
    }

    /**
     * Check if user has verified email
     *
     * @return bool
     */
    public function isEmailVerified()
    {
        return $this->email && $this->email_verified_at;
    }

    /**
     * Check if user has verified email
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->isEmailVerified() || $this->isPhoneVerified();
    }

    /**
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return (bool) $this->attributes['admin_since'];
    }

    public function getProfileImageAttribute()
    {
        return $this->attributes['profile_photo_path'] ? : config('app_settings.values.default_profile_image');
    }
}
