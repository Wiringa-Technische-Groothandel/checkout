<?php

namespace WTG\Checkout\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Add product request
 *
 * @package     WTG\Checkout
 * @subpackage  Requests
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class AddProductRequest extends FormRequest
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
            "product" => ["required", "exists:products,id"],
            "quantity" => ["required", "min:1", "max:1000", "numeric"]
        ];
    }
}
