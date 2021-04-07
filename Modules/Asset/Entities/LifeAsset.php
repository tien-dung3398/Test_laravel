<?php

namespace Modules\Asset\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LifeAsset
 * @package Modules\Asset\Entities
 * @property int $id
 * @property int $asset_id
 * @property int $type
 * @property int $lifeassetable_id
 * @property string $lifeassetable_type
 * @property int $created_by
 * @property string $note
 * @property Collection | LifeAsset []| $lifeassetable
 * @property $created_at
 * @property $updated_at
 * @property Collection |LifeAssetRow[] | $lifeAssetRow
 */
class LifeAsset extends Model
{
    const SET_BARCODE = 10; // TẠO MỚI TÀI SẢN
    const CREATE_ASSET = 15; // TẠO MỚI TÀI SẢN
    const ALLOCATION = 20; // CẤP PHÁT TÀI SẢN
    const RECOVERY = 30; // THU HỒI TÀI SẢN
    const UPDATE_PROPERTY = 40; // CẬP NHẬT THUỘC TÍNH
    const LOCATION = 50; // VỊ TRÍ
    const BROKEN = 60; // TÀI SẢN HỎNG
    const LOST = 70; // MẤT TÀI SẢN
    const LIQUID = 80; // THANH LÝ

    /**
     * @var string
     */
    protected $table = 'life_asset';

    /**
     * @var string[]
     */
    protected $fillable = [
        'asset_id',
        'type',
        'lifeassetable_id',
        'lifeassetable_type',
        'created_by',
        'note'
    ];

    protected $dates = ['created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function lifeassetable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function lifeAssetRow()
    {
        return $this->morphMany(LifeAssetRow::class, 'lifeassetrowable');
    }

}
