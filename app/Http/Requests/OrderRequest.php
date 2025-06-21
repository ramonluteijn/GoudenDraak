<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules = [];
        $products = Product::all();

        foreach ($products as $product) {
            $rules["product_quantity_{$product->id}"] = [
                'nullable',
                'integer',
                'min:1',
                'max:' . $product->stock,
                function ($attribute, $value, $fail) use ($product) {
                    if ($value > $product->stock) {
                        $fail("Het aantal voor {$product->name} mag niet groter zijn dan de beschikbare voorraad ({$product->stock}).");
                    }
                },
            ];
        }

        return $rules;
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hasAtLeastOne = false;
            foreach (Product::all() as $product) {
                $value = $this->input("product_quantity_{$product->id}");
                if (!is_null($value) && $value !== '') {
                    $hasAtLeastOne = true;
                    break;
                }
            }
            if (!$hasAtLeastOne) {
                $validator->errors()->add('product_quantity', 'Vul voor minstens één product een aantal in.');
            }
        });
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
            'product_quantity_*.*' => 'Het aantal moet een geheel getal zijn tussen 1 en het maximaal aantal in voorraad.',
            'product_quantity_*.*.max' => "Het aantal mag niet groter zijn dan de beschikbare voorraad.",
            'product_quantity_*.*.min' => 'Het aantal moet minimaal 1 zijn.',
        ];
    }
}
