<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * A Role can belong to many Users (many-to-many)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
                    ->using(UserRole::class)
                    ->withTimestamps();
    }

    /**
     * Check if a role is assigned to a given user
     */
    public function hasUser(int $userId): bool
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Assign this role to a user
     */
    public function assignToUser(User $user): void
    {
        if (!$this->hasUser($user->id)) {
            $this->users()->attach($user->id);
        }
    }

    /**
     * Remove this role from a user
     */
    public function removeFromUser(User $user): void
    {
        $this->users()->detach($user->id);
    }

    /**
     * Scope to get role by name easily
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Check if this role is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->name === 'superadmin';
    }

    /**
     * Check if this role is futsal admin
     */
    public function isFutsalAdmin(): bool
    {
        return $this->name === 'futsal_admin';
    }

    /**
     * Check if this role is normal player
     */
    public function isPlayer(): bool
    {
        return $this->name === 'player';
    }
}
