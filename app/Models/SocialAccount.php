<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_user_id',
        'provider',
        'name',
        'nickname',
        'email',
        'avatar',
        'access_token',
        'refresh_token',
        'expires_in',
    ];

    /**
     * Get user of this account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
