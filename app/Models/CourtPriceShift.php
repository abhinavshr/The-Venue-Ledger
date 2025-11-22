<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourtPriceShift extends Model
{
    protected $table = 'court_price_shifts';

    protected $fillable = [
        'court_id',
        'start_time',
        'end_time',
        'price_per_hour',
    ];
}
