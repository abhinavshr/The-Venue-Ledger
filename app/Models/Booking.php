<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'court_id',
        'start_time',
        'end_time',
        'number_of_players',
        'total_price',
    ];

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
