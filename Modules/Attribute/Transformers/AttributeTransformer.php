<?php

namespace Modules\Attribute\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Attribute\Entities\Attribute;
use Modules\Category\Transformers\CategoryTransformer;
use phpDocumentor\Reflection\Types\Collection;

class AttributeTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['categories'];

    /**
     * @param Attribute $attribute
     * @return array
     */
    public function transform(Attribute $attribute)
    {
        return [
            'id' => $attribute->id,
            'name' => $attribute->name,
            'description' => $attribute->description,
            'group' => $attribute->group,
            'type' => $attribute->type,
            'created_at' => $attribute->created_at,
            'updated_at' => $attribute->updated_at,
        ];
    }

    /**
     * @param Attribute $attribute
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeCategories(Attribute $attribute){
        $categories = $attribute->categories ;
        return  $categories ? $this->collection(  $categories,new CategoryTransformer()) : null;
    }
}
