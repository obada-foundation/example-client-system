<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComputeChecksumRequest extends FormRequest
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
            'manufacturer'  => 'required|string|max:255',
            'part_number'   => 'required|string|max:255',
            'serial_number' => 'required|string|max:255'
        ];
    }
}
