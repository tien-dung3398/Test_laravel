<?php

namespace Modules\Asset\Http\Requests;

use App\Http\Requests\ApiBaseRequest;
use Modules\Barcode\Entities\Barcode;
use Modules\Asset\Helpers\AssetHelper;
use Modules\Attribute\Entities\Attribute;

/**
 * Asset API Request
 *
 * Class AssetCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AssetCreateApiRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param null $attributes
     * @return string[]
     */
    public function rules($attributes = null)
    {
        // nếu tồn tại category_id thì lọc toàn bộ attr thuộc category này
        if ($this->input('category_id')) {
            $categoryId = $this->input('category_id');
            $attributes = (new Attribute())->relationshipCategory($categoryId);

        }

        // validation asset
        $rules = [
            'name' => 'required|unique:assets,name',
            'code' => 'required|unique:assets,code',
            'asset_images_uploaded' => 'exists:images,id',
            'category_id' => 'required|exists:categories,id'
        ];

        //check mã barcode
        $rules['barcode'] = ['bail','nullable', 'exists:barcodes,value', 'unique:assets,barcode',
            function ($attribute, $value, $fail) {
                $check = Barcode::where(['value' => $value, 'asset_id' => null])->first();
                if (!$check) {
                    return $fail('Mã vạch đã được gán tài sản');
                }
            }];

        // xứ lý validation attribute
        foreach ($this->input('attributes') as $key => $value) {
            // attribute đã tạo kiểm tra xem có thuộc category không
            if (isset($value['id']) && $value['id'] > 0) {
                $id = $value['id'];
                $rules['attributes.' . $key . '.id'] = [
                    function ($attribute, $value, $fail) use ($attributes) {
                        AssetHelper::checkAttributeCategory($attributes, $attribute, $value, $fail);
                    }];
            } else {
                //  validation tạo mới thuộc tính
                $rules['attributes.' . $key . '.name'] = 'required|unique:attributes,name';
                $rules['attributes.' . $key . '.type'] = 'required';
            }
        }

        return $rules;
    }


    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên tài sản không được để trống',
            'name.unique' => 'Tên tài sản đã tồn tại',
            'code.required' => 'Mã tài sản không được để trống',
            'code.unique' => 'Mã tài sản đã tồn tại',
            'barcode.unique' => 'Mã vạch tài sản đã tồn tại',
            'barcode.exists' => 'Mã vạch không tồn tại',
            'category_id.required' => 'Danh mục không được để trống',
            'category_id.exists' => 'Danh mục không tồn tại',
            'attributes.*.id.exists' => 'Id thuộc tính không tồn tại',
            'attributes.*.id.required' => 'Id thuộc tính không được để trống',
            'attributes.*.name.required' => 'Tên thuộc tính không được để trống',
            'attributes.*.name.unique' => 'Tên thuộc tính đã tồn tại',
            'attributes.*.type.required' => 'Mã thuộc tính không  được để trống',
        ];
    }
}
