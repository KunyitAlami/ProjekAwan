<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubscription extends Model
{
    protected $guarded = ['id'];

    public function package() {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function getUsedVcpuAttribute()
    {
        return $this->resources()
            ->virtualMachines()
            ->running()
            ->get()
            ->sum(function ($resource) {
                return $resource->metadata['vcpu'] ?? 0;
            });
    }

    public function getRemainingVcpuAttribute()
    {
        return $this->package->vcpu_limit - $this->used_vcpu;
    }

    public function getUsedRamAttribute()
    {
        return $this->resources()
            ->virtualMachines()
            ->running()
            ->get()
            ->sum(function ($resource) {
                return $resource->metadata['ram_mb'] ?? 0;
            });
    }
}