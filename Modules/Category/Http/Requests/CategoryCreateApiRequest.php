<?php

namespace Modules\Category\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Category API Request
 *
 * Class CategoryCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class CategoryCreateApiRequest extends ApiBaseRequest
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
            'name' => 'required|unique:categories,name|max:50',
            'code' => 'required|unique:categories,name|max:50'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'code.required' => 'Mã danh mục không được để trống',
            'code.unique' => 'Mã danh mục đã tồn tại',
        ];
    }
}
