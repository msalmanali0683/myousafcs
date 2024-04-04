<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Labour extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function invoice_labour(): HasMany
    {
        return $this->hasMany(InvoiceLabour::class);
    }
}