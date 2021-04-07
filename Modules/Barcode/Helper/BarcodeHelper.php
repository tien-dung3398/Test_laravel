<?php

namespace Modules\Barcode\Helper;

use Modules\Barcode\Entities\Barcode;

/**
 * Class BarcodeHelper
 * @package Modules\Barcode\Helper
 */
class BarcodeHelper
{
    /**
     * @return string
     */
    public function barcode($number)
    {
        $barcode = 880000000000 + intval($number);
        $barcodeS = strval($barcode);
        $barcodeSRev = strrev($barcodeS);
        $multiples = 0;
        $oddRL = 0;
        $oddLR = 0;
        for ($i = 0; $i < strlen($barcodeS); $i++) {
            if ($i % 2 == 0) {
                $oddRL += intval($barcodeSRev[$i]); //1. cộng các số lẻ từ phải sang trái
                $oddLR += intval($barcodeS[$i]); //2. cộng các số lẻ từ trái sang phải
            }
        }
        $oddRL *= 3; //3. lấy kết quả (1) x 3
        $sum = $oddRL + $oddLR; //4. cộng kết quả (3) và (2)
        //Tìm ra số check
        if ($sum % 10 == 0) {
            $barcodeResult = strval($barcode) . '0';
        } else {
            for ($i = 1; $i <= 9; $i++) {
                if (($sum + $i) % 10 == 0) {
                    $multiples = $sum + $i;
                    break;
                }
            }
            $barcodeResult = strval($barcode) . strval($multiples - $sum);
        }
        return $barcodeResult;
    }

    /**
     * @param $barcode
     * @return array
     */
    public function checkBarcodes($barcode)
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
}

?>
