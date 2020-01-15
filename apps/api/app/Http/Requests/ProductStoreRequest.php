<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'sku' => 'required|string|max:40|unique:products',
            'title' => 'required|string',
            'url' => 'required|string',
            'price' => 'required',
        ];
    }
}
