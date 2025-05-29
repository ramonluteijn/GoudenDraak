<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock' => 'required|integer|min:0|max:2147483647',
            'type' => 'required'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
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
            'name.required' => 'De productnaam is verplicht.',
            'name.max' => 'De productnaam mag niet langer zijn dan 255 tekens.',
            'description.string' => 'De productbeschrijving moet een geldige tekst zijn.',
            'description.max' => 'De productbeschrijving mag niet langer zijn dan 1000 tekens.',
            'price.required' => 'De prijs is verplicht.',
            'price.numeric' => 'De prijs moet een geldig getal zijn.',
            'price.min' => 'De prijs moet minimaal 0 zijn.',
            'price.max' => 'De prijs mag niet hoger zijn dan 999999.99.',
            'stock.required' => 'De voorraad is verplicht.',
            'stock.integer' => 'De voorraad moet een geldig geheel getal zijn.',
            'stock.min' => 'De voorraad moet minimaal 0 zijn.',
            'stock.max' => 'De voorraad mag niet hoger zijn dan 2147483647.',
            'type.required' => 'Het type product is verplicht.',
        ];
    }
}
