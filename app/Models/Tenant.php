<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'contact_email',
        'contact_phone',
        'logo_url',
    ];

    /**
     * A Tenant can have many Users (Managers, Staff, etc.).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
