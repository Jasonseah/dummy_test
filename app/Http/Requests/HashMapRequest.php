<?php

namespace App\Http\Requests;

use App\Rules\ObjectOrString;
use App\Rules\OnlyOneJsonAllow;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class HashMapRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @throws ValidationException
     */
    public function rules(): array
    {
        // check if request is empty and return a validation error
        if (count($this->request->all()) < 1) {
            throw ValidationException::withMessages([trans('validation.custom.must_have_at_least_one_object')]);
        }

        $rule = [];
        foreach ($this->request->all() as $key => $value) {
            // check if the value is int will return error
            if (is_int($key)){
                throw ValidationException::withMessages([trans('validation.custom.must_be_a_valid_string')]);
            }

            $rule["$key"] = [
                'required',
                new OnlyOneJsonAllow($this->request->all()),
                new ObjectOrString
            ];
        }

        return $rule;
    }
}
