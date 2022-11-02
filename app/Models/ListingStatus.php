<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reason',
    ];
    public function __toString(): string
    {
        return $this->name;
    }
}
