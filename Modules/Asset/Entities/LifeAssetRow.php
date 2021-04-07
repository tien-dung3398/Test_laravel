<?php

namespace Modules\Asset\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LifeAsset
 * @package Modules\Assets\Entities
 * @property User | null| $user;
 * @property string $type;
 * @property int $id;
 * @property int $life_asset_id;
 * @property int $user_used
 * @property int $unit_used
 * @property int $status_asset
 * @property string $value_before;
 * @property string $value_after;
 * @property int $lifeassetrowable_id;
 * @property string $lifeassetrowable_type;
 * @property string $name_property;
 * @property LifeAsset[] |Collection $lifeAsset
 */
class LifeAssetRow extends Model
{
    /**
     * @var string
     */
    protected $table = 'life_asset_rows';

    /**
     * @var array
     */
    protected $fillable = ['id', 'life_asset_id', 'value_before', 'value_after', 'lifeassetrowable_id', 'lifeassetrowable_type', 'name_property', 'type'
        , 'status_asset', 'unit_used', 'user_used'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function lifeassetrowable()
    {
        return $this->morphTo();
    }

}
