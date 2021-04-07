<?php

namespace Modules\Barcode\Repositories;

use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Modules\Asset\Entities\LifeAsset;
use Modules\Barcode\Entities\Barcode;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Modules\Barcode\Helper\BarcodeHelper;


/**
 * Class BarcodeRepository
 * @package Modules\Platform\User\Repositories
 */
class BarcodeRepository extends BaseRepository
{
    /**
     * @var
     */
    protected $barcodeHelper;

    /**
     * BarcodeRepository constructor.
     * @param Application $app
     * @param BarcodeHelper $barcodeHelper
     */
    public function __construct(Application $app, BarcodeHelper $barcodeHelper)
    {
        parent::__construct($app);
        $this->barcodeHelper = $barcodeHelper;

    }

    /**
     * @return string
     */
    public function model()
    {
        return Barcode::class;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return Barcode
     * @throws ValidatorException
     *
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Barcode
     * @throws ValidatorException
     *
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }

    /**
     * @param $quantity
     * @param $barcodeRow_id
     * @return array
     */
    public function createBarcodes($quantity, $barcodeRow_id)
    {
        $barcodes = [];
        $initialization_number = Barcode::query()->max('id') ?? 0;
        for ($i = 1; $i <= $quantity; $i++) {
            $initialization_number += 1;
            $barcodes[] = ['value' => $this->barcodeHelper->barcode($initialization_number),
                'barcode_rows_id' => $barcodeRow_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        $arr = array_chunk($barcodes, 500);
        if (count($arr) > 0) {
            foreach ($arr as $key => $arrBarcode) {
                $this->insert($arrBarcode);
            }
        }
        return $barcodes;
    }

    /**
     * @param $barcode
     * @return array
     */
    public function searchBarcodes($barcode)
    {
        $barcodes = Barcode::query()->where('value', $barcode)->first();
        if (!$barcodes) {
            return [false, null];
        } elseif (!empty($barcodes->asset_id)) {
            return [false, $barcodes];
        } else {
            return [true, $barcodes];
        }
    }

    /**
     * @param $barcode
     * @param $asset_id
     * @return array
     */
    public function setBarcodes($barcode, $asset_id)
    {
        list($invalid, $barcodes) = $this->searchBarcodes($barcode);
        if ($invalid == false) {
            return [false, null];
        } else {
            $barcodes->update([
                'time_set' => carbon::now(),
                'asset_id' => $asset_id
            ]);
            // Ghi lại log khi gán mã tài sản
            $barcodes->lifeAsset()->create([
                'asset_id' => $asset_id,
                'type' => LifeAsset::SET_BARCODE,
                'created_by' => 1
            ]);
            // tính tổng số barcode đã sử dụng
            $barcodes->barcodeRows()->increment('quantity_used', 1);

            return [true, $barcodes];
        }
    }
}
