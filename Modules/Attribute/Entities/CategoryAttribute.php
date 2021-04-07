<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;

/**
 * Class CategoryAttribute
 * @package Modules\Attribute\Entities
 * @property int $category_id
 * @property int $attribute_id
 */
class CategoryAttribute extends Model
{
    /**
     * @var string
     */
    protected $table = 'categrory_attributes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'attribute_id'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];


}
