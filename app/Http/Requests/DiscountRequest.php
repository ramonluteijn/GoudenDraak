<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount' => 'required|integer|min:0|max:100',
            'product_id'=> 'required|array',
        ];

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'start_date' => 'Startdatum',
            'end_date' => 'Einddatum',
            'discount' => 'Korting',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_date.required' => 'De startdatum is verplicht.',
            'end_date.required' => 'De einddatum is verplicht.',
            'end_date.after_or_equal' => 'De einddatum moet gelijk aan of na de startdatum zijn.',
            'discount.required' => 'De korting is verplicht.',
            'discount.integer' => 'De korting moet een geheel getal zijn.',
            'discount.min' => 'De korting moet minimaal 0 zijn.',
            'discount.max' => 'De korting mag maximaal 100 zijn.',
            'product_id.required' => 'Er moet minimaal één product worden geselecteerd.', // Custom error message
        ];
    }
}
