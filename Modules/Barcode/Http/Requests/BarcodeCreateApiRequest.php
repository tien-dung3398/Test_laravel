<?php

namespace Modules\Barcode\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

/**
 * Barcode API Request
 *
 * Class BarcodeCreateApiRequest
 * @package Modules\Api\Http\Requests
 */
class BarcodeCreateApiRequest extends ApiBaseRequest
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
     * @return array[]
     */
    public function rules()
    {

        return [
            'category_id' => 'exists:categories,id',
            'quantity' => ['required', 'int', function ($attribute, $value, $fail) {
                if ($value <= 0) {
                    return $fail('Số lượng phải lớn hơn 0');
                }
            }],
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'category_id.exists' => 'Danh mục không tồn tại',
            'quantity.required' => 'Số lượng không được để trống',
            'quantity.integer' => 'Số lượng phải là dạng ỉnteger',
        ];
    }
}
