<?php

namespace Modules\Category\Http\Requests;

use App\Http\Requests\ApiBaseRequest;

class SetAttributeRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

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
            'attributes' => 'required|array',
            'attributes.*.id' => 'nullable|exists:attributes,id',
            'attributes.*.name' => 'required_without:attributes.*.id|unique:attributes,name',
            "attributes.*.type" => "required_without:attributes.*.id|in:string,int,date,text,float",
            "attributes.*.group" => "nullable|in:10,20,30"
        ];
    }


}
