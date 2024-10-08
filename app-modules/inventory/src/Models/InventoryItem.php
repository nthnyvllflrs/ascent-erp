<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'unit_of_measure',
        'price',
        'location',
        'status',
        'image',
        'notes',
    ];

    /**
     * Get the stock record associated with the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function inventoryStock()
    {
        return $this->hasOne(
            InventoryStock::class,
            'inventory_item_id',
            'id'
        );
    }
}
