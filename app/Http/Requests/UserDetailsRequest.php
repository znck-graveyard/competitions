<?php namespace App\Http\Requests;


class UserDetailsRequest extends Request
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'short_bio' => 'required',
            'profile_pic' => 'image',
            'cover_image' => 'image'
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forbiddenResponse()
    {
        return $this->redirector->route('login');
    }

}
