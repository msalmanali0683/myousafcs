<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function adjustment(): HasMany
    {
        return $this->hasMany(InvoiceAdjustment::class);
    }

    public function product_transactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function labour(): HasOne
    {
        return $this->hasOne(InvoiceLabour::class);
    }

    public function logistic(): HasOne
    {
        return $this->hasOne(InvoiceLogistics::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
