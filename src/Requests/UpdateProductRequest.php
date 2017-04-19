<?php

namespace WTG\Checkout\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update product request
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "quantity" => "required"
        ];
    }
}
