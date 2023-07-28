<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compte extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
