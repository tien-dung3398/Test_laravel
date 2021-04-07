<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;

/**
 * Class Category
 * @property int $id
 * @package Modules\Category\Entities
 * @property string $name
 * @property string $code
 * @property string $slug
 * @property $created_at
 * @property $updated_at
 * @property Collection |attribute []  | $attributes
 */

class Category extends Model
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
        'slug'
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
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'categrory_attributes', 'category_id', 'attribute_id');
    }
}
