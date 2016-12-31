<?php namespace JobApis\JobsToMail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'regex' =>'The location should be formatted 
                "City, ST". Currently only works for US locations.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'keyword' => 'required',
            'location' => 'required|regex:/([^,]+), \s*(\w{2})/',
            'no_recruiters' => 'required',
        ];
    }
}
