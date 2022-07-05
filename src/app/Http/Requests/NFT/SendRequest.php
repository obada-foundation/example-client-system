<?php

namespace App\Http\Requests\NFT;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Bech32;

class SendRequest extends FormRequest
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
            'recipient' => ['required', new Bech32],
        ];
    }
}
