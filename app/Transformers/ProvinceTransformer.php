<?php
namespace App\Transformers;

use App\Province;
use League\Fractal\TransformerAbstract;

class ProvinceTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(Province $province)
    {
        return [
            'id' => $province->id,
            'name' => $province->name
        ];
    }
}