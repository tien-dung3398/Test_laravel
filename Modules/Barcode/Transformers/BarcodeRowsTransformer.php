<?php

namespace Modules\Barcode\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Barcode\Entities\BarcodeRow;

class BarcodeRowsTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['barcodes'];

    public function transform(BarcodeRow $barcodeRow)
    {
        return [
            'id' => $barcodeRow->id,
            'name' => 'Nguyễn Tiến Dũng',
            'quantity' => $barcodeRow->quantity,
            'created_at' => $barcodeRow->created_at,
            'updated_at' => $barcodeRow->updated_at,
        ];
    }

    /**
     * @param BarcodeRow $barcodeRow
     * @return array|\League\Fractal\Resource\Collection
     */
    public function includeBarcodes(BarcodeRow $barcodeRow)
    {
        $barcode = $barcodeRow->barcodes;
        return $barcode ? $this->collection($barcode, new BarcodeTransformer()) : [];
    }
}
