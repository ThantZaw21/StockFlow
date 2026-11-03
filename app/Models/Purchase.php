<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    //
    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'total_amount',
        'status'
    ];

    //A purchase belongs to one supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    //A purchase contains multiple purchase items
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }
}
