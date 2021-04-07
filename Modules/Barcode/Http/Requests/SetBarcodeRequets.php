<?php

namespace Modules\Barcode\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

class SetBarcodeRequets extends ApiBaseRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'asset_id' => 'required|int|exists:assets,id|unique:barcodes,asset_id',
            'barcode' => 'required|int'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'asset_id.required' => 'Id tài sản không được để trống',
            'asset_id.integer' => 'Id tài sản phải là dạng integer',
            'asset_id.unique' => 'Tài sản đã được gán mã vạch',
            'asset_id.exists' => 'Id tài sản không tồn tại',
            'barcode.required' => 'Mã vạch không được để trống',
            'barcode.integer' => 'Mã vạch phải là dạng integer',
        ];
    }


}
