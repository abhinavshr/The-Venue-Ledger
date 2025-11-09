<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class FutsalVenueScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if ($futsalVenue = Auth::user()?->futsalVenue) {
            $builder->where($model->getTable() . '.futsal_venue_id', $futsalVenue->id);
        }
    }
}
