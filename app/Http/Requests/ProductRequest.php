<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category'=>'required',
            'subcategory'=>'required',
            'product_name'=>'required',
            'product_price'=>'required',
            'long_desp'=>'required',
            'preview'=>'required|image',
            'gallery'=>'required',
        ];
    }
    public function messages(): array
    {
        return [
            'category.required'=>'category select kor',
            'subcategory.required'=>'subcategory de',
            'product_name.required'=>'product nam ki',
            'product_price.required'=>'price de',
            'long_desp.required'=>'long description laga',
            'preview.required'=>'preview image koi',
            'gallery.required'=>'gallery o de',
        ];
    }
}
