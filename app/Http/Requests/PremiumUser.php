<?php namespace JobApis\JobsToMail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PremiumUser extends FormRequest
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
        return [];
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
            'employer' => 'required',
            'location' => 'required',
            'name' => 'required',
        ];
    }
}
