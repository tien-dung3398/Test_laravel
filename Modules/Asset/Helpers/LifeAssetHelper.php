<?php

namespace Modules\Asset\Helpers;

class LifeAssetHelper
{
    /**
     * @param $action
     * @return string
     */
    public static function actionLog($action)
    {
        switch ($action) {
            case 15:
                $act = 'tạo mơi tài sản';
                break;
            case 10:
                $act = 'gán mã vạch';
                break;
            default:
                $act = null;
        }
        return $act;
    }

}

?>
