<?php namespace App\Http\Requests;

use Illuminate\Auth\Guard;

/**
 * Class CreateContestRequest
 *
 * @package App\Http\Requests
 */
class CreateContestRequest extends Request
{
    protected $contestId = 'null';
    protected $user;

    /**
     * @param \Illuminate\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->is_maintainer;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'            => 'required|string',
            'slug'            => 'required|unique:contests,slug,' . $this->contestId,
            'contest_type'    => ['required', 'in' => array_keys(config('contest.types', []))],
            'submission_type' => ['required', 'in' => array_keys(config('contest.submission_types', []))],
            'start_date'      => 'required|date',
            'start_time'      => 'required',
            'end_date'        => 'required|date',
            'end_time'        => 'required',
            'rules'           => 'required|min:10',
            'description'     => 'required|min:10',
            'max_entries'     => 'required|integer|min:1',
            'max_iteration'   => 'required|integer|min:1',
            'prize'           => 'required|integer|min:0',
            'prize_1'         => 'required',
            'prize_2'         => 'required',
            'prize_3'         => 'required',
        ];
    }

    /**
     * Validate the class instance.
     *
     * @return void
     */
    public function validate()
    {
        $this->prepare();
        parent::validate();
    }


    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'slug' => [
                'required' => 'A unique url is required for the contest.',
                'unique'   => 'Another contest exists with same url.',
            ]
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forbiddenResponse()
    {
        return $this->redirector->route('contest.create')->withErrors('You are not allowed to create a contest.');
    }

    /**
     * @return void
     */
    protected function prepare()
    {
        if (!$this->request->has('slug')) {
            $slug = str_slug($this->get('name'));
            if (!strlen($slug)) {
                $slug = '------';
            }
            $this->request->set('slug', $slug);
        }

        $contest = $this->route('contest');
        if ($contest) {
            $this->contestId = $contest->id;
        }
    }

}
