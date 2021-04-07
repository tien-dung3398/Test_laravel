<?php

namespace Modules\Barcode\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BarcodeRow
 * @package Modules\Barcode\Entities
 * @property int $id
 * @property int $quantity
 * @property int $created_by
 * @property int $quantity_used
 * @property int $category_id
 * @property $created_at
 * @property $updated_at
 * @property Collection | Barcode [] | $barcodes
 */
class BarcodeRow extends Model
{
    /**
     * @var string
     */
    protected $table = 'barcode_rows';

    /**
     * @var string[]
     */
    protected $fillable = [
        'quantity',
        'created_by',
        'quantity_used',
        'category_id'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barcodes()
    {
        return $this->hasMany(Barcode::class, 'barcode_rows_id', 'id');
    }

    /**
     * @param $category_id
     * @param $created_by
     * @param $quantity
     * @return BarcodeRow
     */
    public function createBarcodeRows($category_id, $created_by, $quantity)
    {
        $barcodeRows = new BarcodeRow();
        $barcodeRows->fill([
            'created_by' => $created_by,
            'category_id' => $category_id,
            'quantity' => $quantity
        ]);
        $barcodeRows->save();

        return $barcodeRows;
    }
}
