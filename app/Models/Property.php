<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Property extends Model
{
    // 👈 Add this block
    protected $fillable = [
        'user_id',
        'name',
        'address',
    ];
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(\App\Models\User::class);
}
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }
}
