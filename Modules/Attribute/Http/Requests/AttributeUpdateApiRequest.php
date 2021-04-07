<?php

namespace Modules\Attribute\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Attribute API Request
 *
 * Class AttributeCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class AttributeUpdateApiRequest extends ApiBaseRequest
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
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
            'name' => 'required|unique:attributes,name,' . $this->route('id') . ',id|distinct',
            'group' => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'category_ids' => 'Id danh mục phải là dạng mảng',
            'category_ids.*.exists' => 'Danh mục không tồn tại',
            'name.require' => 'Tên thuộc tính không được để trống',
            'name.unique' => 'Tên thuộc tính đã tồn tại',
            'name.distinct' => 'Tên thuộc tính đang bị trùng nhau',
            'group.required' => 'Group thuộc tính không được để trống',
        ];
    }
}
