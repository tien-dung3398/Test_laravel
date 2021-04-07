<?php

namespace Modules\Asset\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;
use Modules\Category\Entities\Category;
use Modules\Image\Entities\Image;

/**
 * Class Asset
 * @package Modules\Assets\Entities
 * @method public addLifeAsset($type, $value = null)
 * @property int $id
 * @property string $name
 * @property int $code
 * @property int $unit_used
 * @property int $user_used
 * @property int $barcode
 * @property int $manager
 * @property int $unit_manager
 * @property string $code_identification
 * @property string $vendor
 * @property int $location_id
 * @property string $note
 * @property  $updated_at
 * @property  $created_at
 * @property string $purchased_date
 * @property int $status
 * @property  Collection | Category [] | $assetCategory belongsToMany
 * @property  Collection | Attribute [] | $assetAttributes belongsToMany
 * @property  Collection |Image [] | $images
 * @property Collection |LifeAsset[] | $life
 * @property Collection |LifeAsset[] | $lifeAsset
 * @property Collection |LifeAssetRow[] | $lifeAssetRow
 */
class Asset extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'barcode',
        'unit_used',
        'user_used',
        'vendor',
        'manager',
        'unit_manager',
        'code_identification',
        'location_id',
        'note',
        'status',
        'purchased_date'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assetCategory()
    {
        return $this->belongsToMany(Category::class, 'asset_category', 'asset_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assetAttributes()
    {
        return $this->belongsToMany(Attribute::class, 'asset_attributes', 'asset_id', 'attribute_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function life()
    {
        return $this->hasMany(LifeAsset::class, 'asset_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function lifeAsset()
    {
        return $this->morphMany(LifeAsset::class, 'lifeassetable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function lifeAssetRow()
    {
        return $this->morphMany(LifeAssetRow::class, 'lifeassetrowable');
    }

}
