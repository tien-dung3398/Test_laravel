<?php

namespace Modules\Attribute\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Attribute API Request
 *
 * Class AttributeCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AttributeCreateApiRequest extends ApiBaseRequest
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
     * @return string[]
     */
    public function rules()
    {
        return [
            'attributes' => "required|array",
            'category_ids' => 'array',
            'category_ids.*' => "exists:categories,id",
            'attributes.*.name' => "required|distinct|unique:attributes,name",
        ];
//        foreach ($this->input('attributes') as $key => $val) {
//            $rules['attributes.' . $key . '.name'] = 'required|unique:attributes,name';
//            $rules['attributes.' . $key . '.type'] = 'required';
//            $rules['attributes.' . $key . '.group'] = 'int';
//        }
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'attributes.required' => 'Không được để trống',
            'attributes.array' => 'Attribute phải là dạng mảng',
            'category_ids.array' => 'Danh mục phải là dạng mảng',
            'category_ids.*exists' => 'Danh mục không tồn tại',
            'attributes.*.name.required' => 'Tên thuộc tính không được để trống',
            'attributes.*.name.distinct' => 'Tên thuộc tính gửi lên bị trùng nhau',
            'attributes.*.name.unique' => 'Tên thuộc tính đã tồn tại',
            'attributes.*.type.required' => 'Kiểu thuộc tính không được để trống',
            'attributes.*.group.integer' => 'Group phải là số nguyên',
        ];
    }
}
