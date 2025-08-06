<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    protected $fillable = [
        'device_id', 'temperature', 'humidity', 'status', 'event_timestamp'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(DeviceData::class);
    }
}
