<?php

namespace Modules\Asset\Helpers;

use Carbon\Carbon;
use Modules\Asset\Entities\LifeAsset;
use Modules\Barcode\Entities\Barcode;

class WriteLog
{
    /**
     * @param $model
     * @param $barcode
     * @param null $status
     */
    public function writeLogPost($model, $barcode, $status = null)
    {
        $available = [
            'asset_id' => $model->id,
            'created_by' => 1
        ];

        if ($status != 'update') {
            $available['type'] = LifeAsset::CREATE_ASSET;
            $model->lifeAsset()->create($available);
        }

        if ($barcode) {
            $available['type'] = LifeAsset::SET_BARCODE;
            $sql = Barcode::query()->where('value', $barcode)->first();
            $sql->update([
                'asset_id' => $model->id,
                'time_set' => Carbon::now()
            ]);
            $sql->lifeAsset()->create($available);
        }
    }

    public function writeLogAsset()
    {
    }

}

?>
