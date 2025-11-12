<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'futsal_venue_id',
        'name',
        'capacity',
        'surface_type',
        'price_per_hour',
        'status'
    ];

    public function futsalVenue()
    {
        return $this->belongsTo(FutsalVenue::class);
    }
}