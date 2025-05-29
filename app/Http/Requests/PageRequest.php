<?php

namespace App\Http\Requests;

use App\Rules\UrlCreation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'url' => ['required', Rule::unique('pages')->ignore($this->route('id')),'regex:/^\S*$/' ,new UrlCreation()],
            'content' => 'nullable|max:65535',
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
            'title.required' => 'De titel is verplicht.',
            'url.required' => 'De URL is verplicht.',
            'url.unique' => 'Deze URL bestaat al.',
            'url.regex' => 'De URL mag geen spaties bevatten.',
            'content.max' => 'De inhoud mag maximaal 65535 tekens bevatten.',
        ];
    }
}
