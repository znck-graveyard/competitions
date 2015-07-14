<?php namespace App\Http\Controllers;

use App\Entry;
use App\Transformer\EntryTransformer;
use App\User;
use File;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Session;
use Storage;


/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ProfileController extends Controller
{
    use ImageResponseTrait, ImageUploadTrait;

    /**
     * @type
     */
    protected $rules;

    /**
     * @type
     */
    protected $redirectPath;

    /**
     * @type \App\User
     */
    protected $user;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->middleware('auth', ['only' => ['update', 'me', 'preferences', 'contests']]);
        $this->user = $auth->user();
    }


    /**
     * @param \App\User $user
     * @param int       $width
     * @param int       $height
     *
     * @return mixed
     */
    public function photo(User $user, $width = 196, $height = 196)
    {
        $path = $user->profile_photo;
        $filename = $path && Storage::disk()->exists($path) ? Storage::disk()->get($path) : public_path('image/placeholder.jpg');

        return $this->sendImageResponse($width, $height, $filename,
            Storage::disk()->exists($path) ? Storage::disk()->lastModified($path) : -86400);
    }

    /**
     * @param \App\User $user
     * @param null      $width
     * @param null      $height
     *
     * @return mixed
     */
    public function cover(User $user, $width = null, $height = null)
    {
        $path = $user->cover_photo;
        $filename = $path && Storage::disk()->exists($path) ? Storage::disk()->get($path) : public_path('image/placeholder-wide.png');

        return $this->sendImageResponse($width, $height, $filename,
            Storage::disk()->exists($path) ? Storage::disk()->lastModified($path) : -86400);
    }

    /**
     * @param \App\User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function entries(Request $request, User $user)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $entries = Entry::with(['contest'])
            ->whereEntryableId($user->id)
            ->whereEntryableType(User::class)
            ->orderBy('created_at')
            ->paginate(16);

        $fractal = new Manager();
        $resource = new \League\Fractal\Resource\Collection($entries, new EntryTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($entries));

        return \Response::json($fractal->createData($resource)->toArray());
    }

    /**
     * @middleware auth
     * @return void
     */
    public function contests()
    {
        $user = $this->user;
        $contests = $user->maintaining()->paginate(16);

        return view('profile.contests', compact('user', 'contests'));
    }

    /**
     * @middleware auth
     * @return \Illuminate\View\View
     */
    public function me()
    {
        $user = $this->user;

        return view('profile.show', compact('user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function preferences()
    {
        $user = $this->user;

        return view('profile.preferences', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, ['profile_photo' => 'image', 'cover_photo' => 'image',]);
        /*
        |--------------------------------------------------------------------------
        | Update user profile.
        |--------------------------------------------------------------------------
        |
        | 1. Check $request for any uploaded files and update them regardless.
        | 2. Validate $request data and fill auto fillable properties.
        | 3. Check for extra properties and fill them.
        |
        */
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = $this->moveFile($file);
            // TODO: Resize image in largest resolution required.
            $this->updateProfilePhoto($filename);
        }

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $filename = $this->moveFile($file);
            // TODO: Resize image in largest resolution required.
            $this->updateCoverPhoto($filename);
        }

        if ($request->get('profile_photo_link')) {
            $this->updateCoverPhoto($this->downloadFile($request->get('profile_photo_link')));
        }

        if ($request->get('cover_photo_link')) {
            $this->updateCoverPhoto($this->downloadFile($request->get('cover_photo_link')));
        }

        $this->validate($request, $this->getRules());

        $this->user->update($request->except(['profile_photo_link', 'cover_photo_link']));

        if (session('maintainer-request') === true) {
            $this->user->is_maintainer = true;
            $this->user->save();
        };

        $url = Session::pull('profile_redirect_path', route('me'));

        return redirect()->to($url);
    }

    /**
     * @param $filename
     *
     * @return void
     */
    protected function updateProfilePhoto($filename)
    {
        $tmp = $this->user->profile_photo;
        $this->user->profile_photo = $filename;
        if (File::exists($tmp)) {
            Storage::disk()->delete($tmp);
        }
    }

    /**
     * @param $filename
     *
     * @return void
     */
    protected function updateCoverPhoto($filename)
    {
        $tmp = $this->user->cover_photo;
        $this->user->cover_photo = $filename;
        if (File::exists($tmp)) {
            Storage::disk()->delete($tmp);
        }
    }

    /**
     * @return array
     */
    private function getRules()
    {
        if (empty($this->rules)) {
            $this->rules = [
                'first_name'         => 'required',
                'last_name'          => 'required',
                'email'              => 'required|email|unique:users,email,' . $this->user->id,
                'username'           => 'alpha_dash|unique:users,username,' . $this->user->id,
                'date_of_birth'      => 'required|date',
                'gender'             => 'required',
                'bio'                => 'required',
                'profile_photo_link' => 'url',
                'cover_photo_link'   => 'url',
            ];
        }

        return $this->rules;
    }
}