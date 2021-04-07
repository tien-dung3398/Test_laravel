<?php
namespace  Modules\Asset\Helpers;

class AssetHelper
{

    /**
     * @param $attributeCategory
     * @param $attribute
     * @param $value
     * @param $fail
     * @return mixed
     */
    public static function checkAttributeCategory($attributeCategory, $attribute, $value, $fail)
    {
        $arrAttributes =  $attributeCategory ? $attributeCategory->toArray() : [];
        if (!in_array($value, $arrAttributes)) {
            return $fail('Thuộc tính không hơp lệ,hoặc không thuộc categories');
        }
    }
}

?>
