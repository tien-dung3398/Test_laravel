<?php

namespace Modules\Asset\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Asset\Entities\LifeAsset;
use Modules\Asset\Helpers\LifeAssetHelper;

class LifeAssetTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param LifeAsset $lifeAsset
     * @return array
     */
    public function transform(LifeAsset $lifeAsset)
    {
        $action = $lifeAsset->type;
        return [
            'id' => $lifeAsset->id,
            'created_by' => $lifeAsset->created_by,
            'action' => LifeAssetHelper::actionLog($action),
            'note' => $lifeAsset->note,
            'created_at' => $lifeAsset->created_at,
            'updated_at' => $lifeAsset->updated_at,
        ];
    }

}
