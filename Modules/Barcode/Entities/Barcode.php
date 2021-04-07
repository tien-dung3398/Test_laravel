<?php

namespace Modules\Barcode\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Asset\Entities\Asset;
use Modules\Asset\Entities\LifeAsset;

/**
 * Class Barcode
 * @property int $id
 * @package Modules\Barcode\Entities
 * @property int $value
 * @property int $barcode_rows_id
 * @property int $asset_id
 * @property int $time_set
 * @property $created_at
 * @property $updated_at
 * @property Collection | BarcodeRow [] | $barcodeRows
 * @property Collection | Asset [] | $asset
 * @property Collection | LifeAsset[] |$lifeAsset
 */
class Barcode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'barcode_rows_id',
        'asset_id',
        'time_set',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barcodeRows()
    {
        return $this->belongsTo(BarcodeRow::class, 'barcode_rows_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function lifeAsset()
    {
        return $this->morphMany(LifeAsset::class, 'lifeassetable');
    }
}
