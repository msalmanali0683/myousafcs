<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceLabour extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function labour(): BelongsTo
    {
        return $this->belongsTo(Labour::class);
    }
}