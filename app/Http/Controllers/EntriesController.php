<?php namespace App\Http\Controllers;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
use App\Contest;
use App\Entry;
use App\Http\Controllers\Auth;
use App\Http\Requests;
use App\Reviewer;
use App\Transformer\EntryTransformer;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Rhumsaa\Uuid\Uuid;
use Session;
use Storage;

/**
 * Class EntriesController
 *
 * @package App\Http\Controllers
 */
class EntriesController extends Controller
{
    use ImageUploadTrait, ImageResponseTrait;

    /**
     * @type \App\User
     */
    protected $user;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['only' => ['create', 'update', 'edit', 'store']]);
        $this->middleware('countView', ['only' => ['show']]);
        $this->middleware('vote', ['only' => ['vote']]);
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

        /** @type \App\Entry\AbstractEntry $view */
        $view = app()->make(config('contest.submission.' . $contest->submission_type));

        return view($view->viewCreate(), compact('contest', 'entry', 'action', 'method', 'submissionFormat'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contest             $contest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Contest $contest)
    {
        if (Entry::whereEntryableId($this->user->id)->whereContestId($contest->id)->count() >= $contest->max_entries) {
            flash('Maximum ' . $contest->max_entries . ' ' . str_plural('submissions',
                    $contest->max_entries) . ' are allowed.');

            return redirect()->back();
        }

        $entry = new Entry;
        $this->fillEntryObject($request, $entry, $contest);
        $entry->contest()->associate($contest);
        $this->user->submissions()->save($entry);

        return redirect()->route('contest.entry.show', [$entry->contest->slug, $entry->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contest             $contest
     * @param \App\Entry               $entry
     *
     * @return \Illuminate\View\View
     * @throws \Symfony\Component\Debug\Exception\UndefinedMethodException
     */
    public function show(Request $request, Contest $contest, Entry $entry)
    {
        $one = $entry;
        $other = Entry::whereContestId($contest->id)->where('contest_id', '!=',
            $entry->id)->orderBy(\DB::raw('random()'))->first();

        if (!$other) {
            flash('There is only one submission. Voting works requires two submissions.');
            $other = $one;
        }

        /** @type \App\Entry\AbstractEntry $view */
        $view = app()->make(config('contest.submission.' . $contest->submission_type));

        if ($request->ajax()) {
            return view($view->viewShow(), compact('one', 'other', 'contest'));
        }

        return view('app', ['content' => view($view->viewShow(), compact('one', 'other', 'contest'))]);
    }

    public function preview(Contest $contest, Entry $entry, $width = 1200, $height = 800)
    {
        $filename = $entry->filename;

        if (!$filename && $contest->submission_type == 'text') {
            $filename = Uuid::uuid4()->toString() . '.jpg';

            $image = \Image::canvas(300, 300, '#efefef')->text(wordwrap($entry->title, 20), 150, 15, function ($font) {
                $font->file(base_path('resources/fonts/Montserrat-Bold.otf'));
                $font->size(24);
                $font->align('center');
                $font->valign('top');
            });

            Storage::disk()->put($filename, (string)$image->encode('jpg', 75));
            $entry->filename = $filename;

            $entry->save();
        }

        return $this->sendImageResponse($width, $height, Storage::disk()->get($filename),
            Storage::disk()->exists($filename) ? Storage::disk()->lastModified($filename) : -86400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Entry $entry
     *
     * @return \Illuminate\View\View
     *
     */
    public function edit(Entry $entry)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Entry               $entry
     *
     * @return \App\Http\Controllers\Response
     */
    public function update(Request $request, Entry $entry)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Entry $entry
     *
     * @return \App\Http\Controllers\Response
     */
    public function destroy(Entry $entry)
    {
        if ($this->user->id == $entry->contest->maintainer_id) {
            $entry->delete();
        }

        return redirect()->back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Entry               $entry
     *
     * @param \App\Contest             $contest
     *
     * @return array
     */
    public function fillEntryObject(Request $request, Entry &$entry, Contest $contest)
    {
        /** @type \App\Entry\AbstractEntry $creator */
        $creator = app()->make(config('contest.submission.' . $contest->submission_type));

        $this->validate(
            $request,
            $creator->rules([
                'title' => 'required|min:5|max:255',
                'agree' => 'required',
            ]),
            $creator->messages(['agree.required' => 'You should agree to terms and conditions in order to participate.',])
        );

        $creator->fill($entry, $request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vote(Request $request)
    {
        $one = Entry::whereUuid($request->get('up'))->first();
        if (!$this->user) {
            $this->session->put('url.intended', route('contest.show', $one->contest->slug));
            return redirect()->route('auth.login');
        }
        /** @type Entry $one */
        $other = Entry::whereUuid($request->get('down'))->first();
        $hash = $request->get('hash');

        if (!$one || !$other || !Hash::check($one->uuid . $other->uuid, $hash)) {
            flash()->error('Invalid voting url.');
        }

        $one->upvotes += 1;
        $one->save();

        flash('Vote received.');

        if ($this->user) {
            $reviewer = new Reviewer;

            $reviewer->contest_id = $one->contest_id;
            $reviewer->entry_id = $one->id;
            $reviewer->user_id = $this->user->id;
            $reviewer->voted_at = Carbon::now();

            $reviewer->save();
        }

        return redirect()->back();
    }
}


