<?php

namespace Modules\Category\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Attribute\Transformers\AttributeTransformer;
use Modules\Category\Entities\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['attributes'];

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'code' => $category->code,
            'slug' => $category->slug,
            'created_at' => $category->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $category->updated_at->format('d-m-Y H:i:s'),
        ];
    }

    /**
     * @param Category $category
     */
    public function includeAttributes(Category $category)
    {
        $attributes = $category->attributes;
        return $attributes ? $this->collection($attributes, new AttributeTransformer()) : [];
    }
}
