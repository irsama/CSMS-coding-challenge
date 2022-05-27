<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InvoiceCalculateRequest extends FormRequest
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
            'rate.energy' => 'required|numeric',
            'rate.time' => 'required|numeric',
            'rate.transaction' => 'required|numeric',
            'cdr.meterStart' => 'required|numeric',
            'cdr.timestampStart' => 'required|date_format:Y-m-d\TH:i:s\Z',
            'cdr.meterStop' => 'required|numeric',
            'cdr.timestampStop' => 'required|date_format:Y-m-d\TH:i:s\Z',
        ];
    }
    public $validator = null;
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
