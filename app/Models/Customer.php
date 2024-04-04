<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function invoice(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function balance(): HasMany
    {
        return $this->hasMany(CustomerBalance::class);
    }
}
