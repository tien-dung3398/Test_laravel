<?php

namespace Modules\Barcode\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Asset\Transformers\AssetTransformer;
use Modules\Barcode\Entities\Barcode;
use Modules\Barcode\Entities\BarcodeRow;

class BarcodeTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['asset'];

    /**
     * @param Barcode $barcode
     * @return array
     */
    public function transform(Barcode $barcode)
    {
        if ($barcode->asset) {
            $active = 1;
        } else {
            $active = 0;
        }
        return [
            'id' => $barcode->id,
            'value' => $barcode->value,
            'active' => $active,
            'created_at' => $barcode->created_at,
            'updated_at' => $barcode->updated_at,
        ];
    }

    /**
     * @param Barcode $barcode
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeAsset(Barcode $barcode)
    {
        $asset = $barcode->asset;
        return $asset ? $this->item($asset, new AssetTransformer()) : null;
    }
}
