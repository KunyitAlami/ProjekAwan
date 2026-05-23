<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credential extends Model
{
    protected $fillable = [
        'user_id',
        'access_key',
        'secret_key',
    ];

    protected $hidden = [
        'secret_key', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}