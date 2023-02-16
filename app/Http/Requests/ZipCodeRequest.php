<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ZipCodeRequest extends FormRequest
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
        $rules = [];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), config("constants.HTTP_STATUS_UNPROCESSABLE_ENTITY")));
    }
    public function withValidator($validator)
    {
        try {
            $validator->after(function ($validator) {
                $pathInfo = $this->getPathInfo();
                $data = explode("/", $pathInfo);
                $parameter = $data[3];
                if (is_numeric($parameter)) {
                    if (strlen(trim($parameter)) > 5) {
                        $validator->errors()->add("len",  trans('messages.maxlength'));
                    }
                } else {
                    $validator->errors()->add("type",trans('messages.not_numeric'));
                }
            });
        } catch (Exception $ex) {
            $validator->errors()->add("incidence", trans('messages.incidence'));
        }
    }
}
