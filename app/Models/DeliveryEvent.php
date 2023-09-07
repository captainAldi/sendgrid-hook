<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryEvent extends Model
{
    use HasFactory;

    protected $table = "delivery_event";
    protected $guarded = [];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

}
