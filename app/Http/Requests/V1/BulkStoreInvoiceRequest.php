<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        //data:[{}]
        return [
            /** use *.property name append */
            '*.customerId' => ['required','integer'],
            '*.amount'     => ['required', 'numeric'],//individual or Business
            '*.status'     => ['required',Rule::in(['B','P','V','b','p','v'])],
            '*.billedDate' => ['required','date_format:Y-m-d H:i:s'],
            '*.paidDate'   => ['date_format:Y-m-d H:i:s','nullable'],

        ];
    }

    protected  function prepareForValidation()
    {
        $data = [];
        /**Iterate each array ,turn input $this->toArray()*/
        foreach ($this->toArray() as $obj){
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date']   = $obj['paidDate'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
