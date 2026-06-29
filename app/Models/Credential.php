<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $table = 'credentials';

    protected $fillable = [
        'user_id',
        'access_key',
        'secret_key',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}