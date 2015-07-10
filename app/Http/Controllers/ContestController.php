<?php namespace App\Http\Controllers;

use App\Contest;
use App\Http\Controllers\Auth;
use App\Http\Requests;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    private $user;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['only' => ['create', 'update', 'edit', 'storeFirstTimeContest', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $type
     *
     * @return Response
     */
    public function category($type)
    {
        $type = strtolower(str_replace('-', ' ', $type));

        $contests = Contest::where('contest_type', $type)->paginate(16);

        return view('contest.category', compact('contests', 'type'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = User::find($this->user->id);

        $contest = new Contest();
        $types = $contest->getTypes();
        $submission_types = $contest->getSubmissionTypes();
        if ($user->is_maintainer === true) {
            return view('contest.create')->with(['contestTypes' => $types, 'submissionTypes' => $submission_types]);
        }

//        session(['maintainer-request' => true]);

        return view('contest.new', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\CreateContestRequest $request
     *
     * @return Response
     * @throws \Exception
     */

    public function store(Requests\CreateContestRequest $request)
    {
        \DB::beginTransaction();
        try {
            $contest = $this->createOrUpdateContest($request);

            $this->user->is_maintainer = true;

            flash()->success("New Contest created successfully!!");

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

        return redirect('contest/{type}');//not sure about return TODO

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contest $contest
     *
     * @return \App\Http\Controllers\Response
     */
    public function show(Contest $contest)
    {
        $contest->load(['entries', 'entries.entryable']);

        $top = $contest->entries->take(3)->sort(function ($a, $b) {
            return $a->score > $b->score;
        });

        return view('contest.show', compact('contest', 'top'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contest = Contest::find($id);
        $user_id = $this->user->id();
        $maintainer_id = $contest->maintainer_id;
        if ($user_id == $maintainer_id) {
            return view('contest.create', compact('contest'));
        } else {
            flash()->warning("Access Denied");

            return redirect()->back();

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                          $id
     * @param Requests\CreateContestRequest $request
     *
     * @return Response
     * @throws \Exception
     */
    public function update($id, Requests\CreateContestRequest $request)
    {
        $contest = Contest::find($id);
        $user_id = $this->user->id();
        $maintainer_id = $contest->maintainer_id;
        if ($user_id == $maintainer_id) {
            \DB::beginTransaction();
            try {
                $this->createOrUpdateContest($request, $contest);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

            \DB::commit();
        } else {
            flash()->warning("Access Denied");

            return redirect()->back();

        }

        return redirect('contest/{type}');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contest = Contest::find($id);
        $user_id = $this->user->id();
        $maintainer_id = $contest->maintainer_id;
        if ($user_id == $maintainer_id) {
            $contest = Contest::find($id);
            $contest->delete();

            return redirect()->home();
        } else {
            flash()->warning("Access Denied");

            return redirect()->back();
        }

    }

    public function createOrUpdateContest(Requests\CreateContestRequest $request, $contest = null)
    {
        if (is_null($contest)) {
            $contest = new Contest();
        }

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
        if ($contest->peer_review_enabled) {
            $contest->peer_review_weightage = $request->get('peer_review_weightage');
        } else {
            $contest->peer_review_weightage = null;
        }

        $contest->manual_review_enabled = $request->get('manual_review_enabled');

        if ($contest->manual_review_enabled) {
            $contest->manual_review_weightage = $request->get('manual_review_weightage');
        } else {
            $contest->manual_review_weightage = null;
        }

        $contest->team_entry_enabled = $request->get('team_entry_enabled');
        $contest->maintainer_id = $this->user->id();
        if ($request->hasFile('contest_banner')) {
            $file = $request->file('contest_banner');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));
            $contest->image = $filename;
        }
        $contest->save();

        $website = '';
        foreach ($request->judges as $judge) {
            $judge_string = str_random(128);
            $contest_id = $contest->id;
            if ((isset($judge['user_id']))) {
                $user_id = $judge['user_id'];
            } else {
                $user_id = null;
            }
            DB::table('judges')->insert(
                [
                    'contest_id'   => $contest->id,
                    'user_id'      => $user_id,
                    'name'         => $judge['name'],
                    'email'        => $judge['email'],
                    'judge_string' => $judge_string
                ]
            );

            $whole_judge_link = 'contest/' . $contest_id . '/' . $judge_string;
            \Mail::queue('emails.judge', ['whole_judge_link' => $whole_judge_link, 'contest' => $contest->name],
                function ($message)
                use ($judge) {
                    $email = $judge['email'];
                    $message->to($email)->subject('Judgement Link');
                });
        }


        return $contest;


    }


}
