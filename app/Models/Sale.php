<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    //
    protected $fillable = [
        'customer_name',
        'sale_date',
        'total_amount',
        'status',
    ];

    protected function casts():array{
        return [
            'sale_date' => 'date',
            'total_amount' => 'decimal:2'
        ];
    }

    public function items():HasMany{
        return $this->hasMany(SaleItem::class);
    }
}
