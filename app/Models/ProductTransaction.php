<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransaction extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function logistic(): BelongsTo
    {
        return $this->belongsTo(Logistic::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
