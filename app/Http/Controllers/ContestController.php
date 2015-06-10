<?php namespace App\Http\Controllers;

use App\Contest;
use App\Http\Requests;
use App\User;
use App\UserAttribute;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $user;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['except' => ['contestCategoryHome', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function contestCategoryHome($type)
    {
        $contests = Contest::where('type', $type)->paginate(16);
        return view('contest.indexCategory', compact('contests'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        if ($this->user->check()) {
            $maintainer_bool = $this->user->is_maintainer;
            if ($maintainer_bool)
                return view('contest.create');
            else
                return view('contest.create_first_time');
        } else
            return redirect('login');
    }

    /**
     * @param Requests\UserDetailsRequest $request
     * @return \Illuminate\View\View
     */
    public function storeFirstTime(Requests\UserDetailsRequest $request)
    {
        
        $id = $this->user->id();
        $moderator = User::find($id);
        $moderator->first_name = ucfirst($request->get('first_name'));
        $moderator->last_name = ucfirst($request->get('last_name'));
        $moderator->email = $request->get('email');
        $moderator->date_of_birth = $request->get('date_of_birth');
        $moderator->gender = $request->get('gender');
        $short_bio = $request->get('short_bio');
        $user_attribute = [
            'user_id' => $id,
            'key' => 'short_bio',
            'value' => $short_bio
        ];
        UserAttribute::create($user_attribute);

        return view('contest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\CreateContestRequest $request
     * @return Response
     */

    public function store(Requests\CreateContestRequest $request)
    {
        $contest = new Contest();
        $s_date = $request->get('start_contest_date');//start date from form
        $s_time = $request->get('start_contest_time');//start time from form
        $s_timestamp = \Carbon::createFromTimestamp($s_date . $s_time);
        $contest->start_date = $s_timestamp;
        $e_date = $request->get('end_contest_date');//end date from form
        $e_time = $request->get('end_contest_time');//end time from form
        $e_timestamp = \Carbon::createFromTimestamp($e_date . $e_time);
        $contest->end_date = $e_timestamp;
        $contest->name = $request->get('name');
        $contest->description = $request->get('description');
        $contest->rules = $request->get('rules');
        $contest->type = $request->get('type');
        $contest->submission_type = $request->get('submission_type');
        $contest->max_entries = $request->get('max_entries');
        $contest->max_iteration = $request->get('max_iteration');
        $contest->peer_review_enabled = $request->get('peer_review_enabled');
        if ($contest->peer_review_enabled)
            $contest->peer_review_weightage = $request->get('peer_review_weightage');
        else
            $contest->peer_review_weightage = NULL;

        $contest->manual_review_enabled = $request->get('manual_review_enabled');

        if ($contest->manual_review_enabled)
            $contest->manual_review_weightage = $request->get('manual_review_weightage');
        else
            $contest->manual_review_weightage = NULL;

        $contest->team_entry_enabled = $request->get('team_entry_enabled');
        $contest->maintainer_id = $this->user->id();

        $contest->save();
        $this->user->is_maintainer = true;

        return redirect('contest/{type}');//not sure about return

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $contest = Contest::findOrFail($id);
        return view('contest.show', compact('contest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

    }


}
