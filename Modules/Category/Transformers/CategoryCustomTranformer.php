<?php

namespace Modules\Category\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Category\Entities\Category;

class CategoryCustomTranformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}
