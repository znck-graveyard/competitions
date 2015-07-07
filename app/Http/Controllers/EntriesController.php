<?php namespace App\Http\Controllers;

use App\Contest;
use App\Entry;
use App\Http\Controllers\Auth;
use App\Http\Requests;
use App\Transformer\EntryTransformer;
use App\User;
use App\UserAttribute;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class EntriesController extends Controller
{

    private $user;

    /**
     * @param Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->middleware('auth', ['only' => ['create', 'update', 'edit', 'storeFirstTimeEntry', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contest             $contest
     *
     * @return \App\Http\Controllers\Response
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
     * @return Response
     */
    public function create()
    {
        $id = $this->user->id;
        $contestant = User::find($id);
        $entries = $contestant->contestantEntries;
        if (is_null($entries)) {
            return $this->entryFirstTime();
        } else {
            return view('entries.create');
        }
    }

    public function entryFirstTime()
    {
        return view('entries.entry_first_time');
    }

    public function storeFirstTimeEntry(Requests\UserDetailsRequest $request)
    {
        $id = $this->user->id();
        $contestant = User::find($id);
        $contestant->first_name = ucfirst($request->get('first_name'));
        $contestant->last_name = $request->get('last_name');
        $contestant->username = $request->get('username');
        $contestant->email = $request->get('email');
        $contestant->date_of_birth = $request->get('date_of_birth');
        $contestant->gender = $request->get('gender');
        $this->userAttributes($request, $id);

        return view('entries.create');

    }

    public function userAttributes(Requests\UserDetailsRequest $request, $id)
    {
        $user_attributes = [];
        $short_bio = $request->get('short_bio');

        $user_attribute_short_bio = [
            'user_id' => $id,
            'key'     => 'short_bio',
            'value'   => $short_bio
        ];

        $user_attributes[] = $user_attribute_short_bio;

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));
            $user_attribute_profile_pic = [
                'user_id' => $id,
                'key'     => 'profile_pic',
                'value'   => $filename
            ];
            $user_attributes[] = $user_attribute_profile_pic;
        }
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));
            $user_attribute_cover_image = [
                'user_id' => $id,
                'key'     => 'cover_image',
                'value'   => $filename
            ];
            $user_attributes[] = $user_attribute_cover_image;
        }

        if ($request->has('facebook_username')) {
            $user_attribute_facebook = [
                'user_id' => $id,
                'key'     => 'facebook_username',
                'value'   => $request->get('facebook_username')
            ];
            $user_attributes[] = $user_attribute_facebook;

        }
        if ($request->has('twitter_username')) {
            $user_attribute_twitter = [
                'user_id' => $id,
                'key'     => 'twitter_username',
                'value'   => $request->get('twitter_username')
            ];
            $user_attributes[] = $user_attribute_twitter;
        }
        if ($request->has('instagram_username')) {
            $user_attribute_instagram = [
                'user_id' => $id,
                'key'     => 'instagram_username',
                'value'   => $request->get('instagram_username')
            ];
            $user_attributes[] = $user_attribute_instagram;

        }
        foreach ($user_attributes as $attribute) {
            UserAttribute::create($attribute);
        }

        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateEntryRequest $request
     *
     * @return \App\Http\Controllers\Response
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
     * @return \App\Http\Controllers\Response
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
     * @return Response
     */
    public function edit($id)
    {
        return view('entries.edit', compact('entries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
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
        Entry::destroy(id);

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

    public function voteEntry()
    {

    }

}


