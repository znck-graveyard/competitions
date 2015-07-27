<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateEntryRequest extends Request
{

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
            'abstract' => 'required|string',
            'filename' => 'required|string',
            'file_type' => 'required|string',
            'file_size' => 'required|decimal',
            'contest_id' => 'required|integer',
            'entryable_id' => 'required|integer',
            'entryable_type' => 'required|string',
            'created_at' => 'required|timestamp',
            'updated_at' => 'required|timestamp',
            'moderation_comment' => 'required_if:moderated,true',
            'manual_review_weightage' => 'required_if:manual_review_enabled,true',
        ];
    }

}