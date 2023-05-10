<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KpiType extends Model
{
    protected $guarded = [];

    public function kpis(): HasMany
    {
        return $this->hasMany(Kpi::class);
    }
}
