<?php

namespace Modules\Attribute\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Attribute\Entities\Attribute;

class AttributesCustomTranformer extends TransformerAbstract
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
        ];
    }
}
