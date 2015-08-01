<?php namespace App\Http\Controllers;

use App\Contest;
use App\Entry;
use App\Http\Controllers\Auth;
use App\Http\Requests;
use App\Http\Requests\CreateContestRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Mail;
use Session;
use Storage;

/**
 * Class ContestController
 *
 * @package App\Http\Controllers
 */
class ContestController extends Controller
{
    use ImageResponseTrait, ImageUploadTrait;
    /**
     * @type \App\User|null
     */
    protected $user;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['except' => ['show', 'category', 'cover']]);
        $this->middleware('countView', ['only' => ['show']]);
    }

    public function index()
    {
        return redirect()->home();
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

        $contests = Contest::wherePublic(true)->where('contest_type', $type)->paginate(16);

        return view('contest.category', compact('contests', 'type'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        /**
         * If use is not a maintainer.
         */
        $user = $this->user;
        if (!$user->is_maintainer) {
            Session::put('maintainer-request', true);
            Session::put('profile_redirect_path', route('contest.create'));
            flash('Before creating contest, please enter some information below.');

            return view('contest.new', compact('user'));
        }
        $contest = new Contest;
        $action = route('contest.store');

        return view('contest.create')->with(compact('contest', 'action'));
    }

    public function request(Contest $contest)
    {
        if ($this->editable($contest)) {
            Mail::queue('emails.publish', [
                'contest'     => $contest->name,
                'slug'        => $contest->slug,
                'token'       => $contest->admin_token,
                'maintainer'  => $contest->maintainer->name,
                'description' => $contest->description_html,
            ], function (Message $message) {
                $message->from(config('publish.from.email'), config('publish.from.name'));
                $verifiers = config('mail.contest.request');
                if (is_array($verifiers)) {
                    foreach ($verifiers as $email => $name) {
                        $message->bcc($email, $name);
                    }
                } elseif (is_string($verifiers)) {
                    $message->bcc($verifiers);
                } else {
                    throw new \InvalidArgumentException('mail.contest.request should be string or array.');
                }
                $message->subject('Publish contest request');
            });

            flash('Contest queued for publishing.');
        }

        return redirect()->route('contest.show', $contest->slug);
    }

    public function review(Contest $contest, $token)
    {
        if ($contest->admin_token !== $token) {
            abort(404);
        }


        $contest->load(['entries', 'entries.entryable']);


        $top = $contest->entries->take(3)->sort(function ($a, $b) {
            return $a->score > $b->score;
        });

        $editable = false;
        $publisher = true;

        return view('contest.show', compact('contest', 'top', 'editable', 'publisher', 'token'));
    }

    public function publish(Contest $contest, $token)
    {
        if ($contest->admin_token !== $token) {
            abort(404);
        }

        $contest->public = !$contest->public;
        $contest->save();
        if ($contest->public) {
            flash('Contest is public now.');
        } else {
            flash('Contest is unpublished. If it was in trending contests, then may take 15-30 minutes to remove from trending contest.');
        }

        return redirect()->back();
    }

    /**
     * @param \App\Contest $contest
     * @param null         $width
     * @param null         $height
     *
     * @return mixed
     */
    public function cover(Contest $contest, $width = null, $height = null)
    {
        $path = $contest->image;
        $filename = $path && Storage::disk()->exists($path) ? Storage::disk()->get($path) : public_path('image/placeholder-wide.png');

        return $this->sendImageResponse($width, $height, $filename,
            Storage::disk()->exists($path) ? Storage::disk()->lastModified($path) : -86400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateContestRequest $request
     *
     * @return Response
     * @throws \Exception
     */

    public function store(CreateContestRequest $request)
    {
        $contest = new Contest;

        $this->fillContest($contest, $request);

        $this->user->maintaining()->save($contest);

        return redirect()->route('contest.show', [$contest->slug]);
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

        if (!$contest->public) {
            if ($this->authorized($contest)) {
                flash()->warning('This contest is not public. Request administrator to publish this contests. <a href="' . route('contest.request',
                        $contest->slug) . '">Send request</a> now.');
            } else {
                abort(404);
            }
        }

        $top = Entry::whereContestId($contest->id)->orderBy('views')->take(3)->get();

        $editable = $this->editable($contest);
        $publisher = false;

        return view('contest.show', compact('contest', 'top', 'editable', 'publisher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contest $contest
     *
     * @return \App\Http\Controllers\Response
     */
    public function edit(Contest $contest)
    {
        if ($this->editable($contest)) {
            $action = route('contest.update', $contest->slug);
            $method = 'put';

            return view('contest.create', compact('contest', 'action', 'method'));
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateContestRequest $request
     *
     * @param \App\Contest         $contest
     *
     * @return \App\Http\Controllers\Response
     * @throws \Exception
     */
    public function update(CreateContestRequest $request, Contest $contest)
    {
        if ($this->editable($contest)) {
            $this->fillContest($contest, $request);

            $this->user->maintaining()->save($contest);
        } else {
            flash('Contest is already published.');
        }

        return redirect()->route('contest.show', [$contest->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contest $contest
     *
     * @return \App\Http\Controllers\Response
     * @throws \Exception
     */
    public function destroy(Contest $contest)
    {
        if ($this->authorized($contest)) {
            if ($contest->public) {
                flash()->warning('Contest is published. Contact admin to unpublish it before deleting.');
            } else {
                $contest->delete();
                flash('Contest has been deleted.');
            }
        }

        redirect()->home();
    }

    protected function fillContest(Contest $contest, Request $request)
    {
        if ($request->hasFile('cover_photo')) {
            $contest->image = $this->moveFile($request->file('cover_photo'));
        }

        if ($request->has('cover_photo_link')) {
            $contest->image = $this->downloadFile($request->get('cover_photo_link'));
        }

        $attributes = $request->all();

        $contest->fill(array_only($attributes,
            [
                'name',
                'slug',
                'contest_type',
                'submission_type',
                'description',
                'rules',
                'max_entries',
                'max_iteration',
                'prize_1',
                'prize_2',
                'prize_3',
                'prize'
            ]));
        $contest->start_date = Carbon::parse(
            array_get($attributes, 'start_date', '') . ' ' .
            array_get($attributes, 'start_time', ''));
        $contest->end_date = Carbon::parse(
            array_get($attributes, 'end_date', '') . ' ' .
            array_get($attributes, 'end_time', ''));
        $contest->peer_review_enabled = true;
        $contest->peer_review_weightage = 1;
        $contest->manual_review_enabled = false;
        $contest->manual_review_weightage = 0;
        $contest->public = false;
        $contest->team_entry_enabled = false;
        $contest->team_size = 1;
        if (!$contest->admin_token) {
            $contest->admin_token = str_random(60);
        }
    }

    /**
     * @param \App\Contest $contest
     *
     * @return bool
     */
    protected function authorized(Contest $contest)
    {
        return $this->user && $this->user->id === $contest->maintainer_id;
    }

    /**
     * @param \App\Contest $contest
     *
     * @return bool
     */
    protected function editable(Contest $contest)
    {
        return $this->authorized($contest) && !$contest->public;
    }

    /**
     * TODO: NOTE: Maybe helpful later.
     * public function createOrUpdateContest(Requests\CreateContestRequest $request, $contest = null)
     * {
     * if (is_null($contest)) {
     * $contest = new Contest();
     * }
     *
     * $s_date = $request->get('start_contest_date');//start date from form
     * $s_time = $request->get('start_contest_time');//start time from form
     * $s_timestamp = \Carbon::createFromTimestamp($s_date . $s_time);
     * $contest->start_date = $s_timestamp;
     * $e_date = $request->get('end_contest_date');//end date from form
     * $e_time = $request->get('end_contest_time');//end time from form
     * $e_timestamp = \Carbon::createFromTimestamp($e_date . $e_time);
     * $contest->end_date = $e_timestamp;
     * $contest->name = $request->get('name');
     * $contest->description = $request->get('description');
     * $contest->rules = $request->get('rules');
     * $contest->type = $request->get('type');
     * $contest->submission_type = $request->get('submission_type');
     * $contest->max_entries = $request->get('max_entries');
     * $contest->max_iteration = $request->get('max_iteration');
     * $contest->peer_review_enabled = $request->get('peer_review_enabled');
     * if ($contest->peer_review_enabled) {
     * $contest->peer_review_weightage = $request->get('peer_review_weightage');
     * } else {
     * $contest->peer_review_weightage = null;
     * }
     *
     * $contest->manual_review_enabled = $request->get('manual_review_enabled');
     *
     * if ($contest->manual_review_enabled) {
     * $contest->manual_review_weightage = $request->get('manual_review_weightage');
     * } else {
     * $contest->manual_review_weightage = null;
     * }
     *
     * $contest->team_entry_enabled = $request->get('team_entry_enabled');
     * $contest->maintainer_id = $this->user->id();
     * if ($request->hasFile('contest_banner')) {
     * $file = $request->file('contest_banner');
     * $extension = $file->getClientOriginalExtension();
     * $filename = $file->getFilename() . '.' . $extension;
     * Storage::disk('local')->put($filename, File::get($file));
     * $contest->image = $filename;
     * }
     * $contest->save();
     *
     * $website = '';
     * foreach ($request->judges as $judge) {
     * $judge_string = str_random(128);
     * $contest_id = $contest->id;
     * if ((isset($judge['user_id']))) {
     * $user_id = $judge['user_id'];
     * } else {
     * $user_id = null;
     * }
     * DB::table('judges')->insert(
     * [
     * 'contest_id'   => $contest->id,
     * 'user_id'      => $user_id,
     * 'name'         => $judge['name'],
     * 'email'        => $judge['email'],
     * 'judge_string' => $judge_string
     * ]
     * );
     *
     * $whole_judge_link = 'contest/' . $contest_id . '/' . $judge_string;
     * \Mail::queue('emails.judge', ['whole_judge_link' => $whole_judge_link, 'contest' => $contest->name],
     * function ($message)
     * use ($judge) {
     * $email = $judge['email'];
     * $message->to($email)->subject('Judgement Link');
     * });
     * }
     * return $contest;
     * }
     */

}
