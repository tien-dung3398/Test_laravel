<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Asset\Entities\Asset;
use Modules\Category\Entities\Category;

/**
 * Class Attribute
 * @property int $id
 * @package Modules\Attribute\Entities
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $group
 * @property $created_at
 * @property $updated_at
 * @property Collection | $categories belongsToMany
 * @property Collection |Asset [] |$attributesAsset
 * @property Relation | Attribute [] |$relationshipCategory
 */
class Attribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'group'
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
    public function categories()
    {
        return $this->belongsToMany(category::class, 'categrory_attributes', 'attribute_id', 'category_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributesAsset()
    {
        return $this->belongsToMany(Asset::class, 'asset_attributes', 'attribute_id', 'asset_id');
    }

    /**
     * @param $categoryId
     * @return \Illuminate\Support\Collection
     */
    public function relationshipCategory($categoryId)
    {
        return Attribute::query()->whereHas('categories', function ($sql) use ($categoryId) {
            $sql->where('category_id', $categoryId);
        })->pluck('id');
    }
}
