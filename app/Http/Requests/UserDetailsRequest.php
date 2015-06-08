<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

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
            'email'=>'required|email|unique',
            'date_of_birth'=>'required|date',
            'gender'=>'required',
            'short_bio'=>'required'
		];
	}

}
