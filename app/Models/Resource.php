<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resource extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function userSubscription() {
        return $this->belongsTo(UserSubscription::class);
    }

    public function objects() {
        return $this->hasMany(CloudObject::class); // Jika ini bucket
    }

    public function scopeVirtualMachines($query) {
        return $query->where('type', 'virtual_machine');
    }

    public function scopeBuckets($query) {
        return $query->where('type', 'bucket');
    }

    public function scopeRunning($query) {
        return $query->where('status', 'running');
    }
}