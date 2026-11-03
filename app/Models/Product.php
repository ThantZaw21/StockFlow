<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'description',
        'purchase_price',
        'selling_price',
        'quantity',
        'reorder_level',
        'is_active',
    ];
    //
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMovement():HasMany{
        return $this->hasMany(StockMovement::class);
    }

    public function purchaseItems():HasMany{
        return $this->hasMany(PurchaseItem::class);
    }
    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'is_active' => 'boolean'
        ];
    }
}
