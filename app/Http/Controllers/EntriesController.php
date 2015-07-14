<?php namespace App\Http\Controllers;

use App\Contest;
use App\Entry;
use App\Http\Controllers\Auth;
use App\Http\Requests;
use App\Reviewer;
use App\Transformer\EntryTransformer;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Session;

class EntriesController extends Controller
{

    /**
     * @type \App\User|null
     */
    protected $user;
    protected $contest;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['only' => ['create', 'update', 'edit', 'store',]]);
        $this->middleware('countView', ['only' => ['show']]);
        $this->middleware('vote', ['only' => ['upVotes', 'downVotes']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contest             $contest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Contest $contest)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $entries = Entry::whereContestId($contest->id)
            ->orderBy('created_at')
            ->paginate(16);

        $fractal = new Manager();
        $resource = new \League\Fractal\Resource\Collection($entries, new EntryTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($entries));

        return response()->json($fractal->createData($resource)->toArray());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Contest $contest
     *
     * @return \Illuminate\View\View
     */
    public function create(Contest $contest)
    {
        if (Carbon::now()->lt($contest->start_date)) {
            abort(404);
        }
        if (Carbon::now()->gt($contest->end_date)) {
            flash()->error('Submissions on this contest are closed.');
            redirect()->back();
        }
        $user = $this->user;
        if (!$user->date_of_birth) {
            Session::put('profile_redirect_path', route('contest.entry.create', $contest->slug));
            flash('Before submitting your entry, please enter some information below.');

            return view('entries.new', compact('user'));
        }

        $entry = new Entry;
        $action = route('contest.entry.store', $contest->slug);
        $method = 'post';
        $submissionFormat = 'submission.image';

        return view('entries.create', compact('contest', 'entry', 'action', 'method', 'submissionFormat'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateEntryRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Requests\CreateEntryRequest $request)
    {
        \DB::beginTransaction();
        try {
            $entry = $this->createOrUpdateEntry($request);
            flash('Your entry has been added.');

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contest $contest
     * @param \App\Entry   $entry
     *
     * @return \Illuminate\View\View
     */
    public function show(Contest $contest, Entry $entry)
    {
        $one = $entry;
        $other = $contest->entries->random();

        return view('comparator.abstract', compact('one', 'other'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        return view('entries.edit', compact('entries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CreateEntryRequest $request
     * @param \App\Entry                            $entry
     *
     * @return \App\Http\Controllers\Response
     * @throws \Exception
     *
     */
    public function update(Requests\CreateEntryRequest $request, Entry $entry)
    {
        \DB::beginTransaction();
        try {
            $this->createOrUpdateEntry($request, $entry);
            if (!$entry->abstract) {
                flash('Your entry has been added.');
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        \DB::commit();

        return redirect()->back();
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
        Entry::destroy($id);

        return redirect()->home();
    }

    public function createOrUpdateEntry(Requests\CreateEntryRequest $request, $entry = null)
    {
        if (is_null($entry)) {
            $entry = new Entry;
        }

        $entry->abstract = ucfirst($request->get('abstract'));
        $file = $request->file('filename');
        $entry->filename = $file->getClientOriginalName();
        $entry->filetype = $file->getExtension();
        $entry->file_size = $file->getMaxFilesize();
        $entry->contest_id = $request->get('contest_id');
        $entry->is_team_entry = $request->get('is_team_entry');
        $entry->entryable_id = $request->get('entryable_id');
        $entry->entryable_type = $request->get('entryable_type');
        $entry->moderated = $request->get('moderated');
        $entry->moderation_comment = $request->get('comment');
        $entry->save();

        return [$entry];
    }

    /**
     * @param Entry $entry_up_voted
     * @param Entry $entry_down_voted
     */
    public function upVotes($contest_uuid, $entry_up_voted_uuid)
    {
        $entry_up_voted = Entry::whereUuid($entry_up_voted_uuid)->first();
        $entry_up_voted->upvotes += 1;
        $entry_up_voted->save();


        $reviewer = new Reviewer();
        if (!($this->auth->guest())) {
            $reviewer->contest_id = $entry_up_voted->contest->id;
            $reviewer->voted_at = Carbon::now();
            $reviewer->entry_id = $entry_up_voted->id;
            $reviewer->user_id = $this->user->id;
            $reviewer->save();
        }

        flash('Thank You for Voting!!');

        return redirect('/contest/' . $entry_up_voted->contest->slug);

    }

    public function downVotes($contest_uuid, $entry_down_voted_uuid)
    {
        $entry_down_voted = Entry::whereUuid($entry_down_voted_uuid)->first();

        $entry_down_voted->downvotes += 1;
        $entry_down_voted->save();

        //TODO check this not sure for downvote response
        return redirect('/contest/' . $entry_down_voted->contest->slug);

    }


}


