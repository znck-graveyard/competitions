<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateContestRequest extends Request
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
            'name' => 'required|string|unique',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'rules' => 'required',
            'description' => 'required',
            'peer_review_weightage' => 'required_if:peer_review_enabled,true',
            'manual_review_weightage' => 'required_if:manual_review_enabled,true',
            'max_entries' => 'required|integer',
            'max_iteration' => 'required|integer',
            'team_size' => 'required_if:team_entry_enabled|true',
            'prize' => 'required',
            'contest_banner' => 'required|image',
            'judges' => 'required_if:manual_review_enabled,true'

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
