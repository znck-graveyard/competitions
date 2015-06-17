<?php namespace App\Http\Requests;

use App\Http\Requests\Request;



class UserDetailsRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()) {
            return true;
        }
        return false;

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
            'email' => 'required|email|unique',
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


class UserDetailsRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        //TODO
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'first_name'=>'required',
            'last_name'=>'required',
            'username' => 'required|string|unique',
            'email'=>'required|email|unique',
            'date_of_birth'=>'required|date',
            'gender'=>'required',
            'short_bio'=>'required'
		];
	}


}


}
