<?php

namespace App\Http\Requests;

use App\Rules\ObjectOrString;
use App\Rules\OnlyOneJsonAllow;
use Illuminate\Foundation\Http\FormRequest;

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
     */
    public function rules(): array
    {
        $rule = [];
        foreach ($this->request->all() as $key => $value) {
            $rule[ $key ] = [
                'required',
                new OnlyOneJsonAllow($this->request->all()),
                new ObjectOrString
            ];
        }

        return $rule;
    }
}
