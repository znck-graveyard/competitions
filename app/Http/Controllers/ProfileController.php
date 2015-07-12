<?php namespace App\Http\Controllers;

use App\Entry;
use App\Transformer\EntryTransformer;
use App\User;
use Carbon\Carbon;
use File;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Rhumsaa\Uuid\Uuid;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ProfileController extends Controller
{
    protected $rules;

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
        $this->middleware('auth', ['only' => ['update', 'me', 'preferences']]);
        $this->user = $auth->user();
    }


    public function photo(User $user, $width = 196, $height = 196)
    {
        $path = $user->profile_photo;
        $filename = $path && Storage::disk()->exists($path) ? Storage::disk()->get($path) : public_path('image/placeholder.jpg');

        return $this->sendImageResponse($width, $height, $filename,
            Storage::disk()->exists($path) ? Storage::disk()->lastModified($path) : -86400);
    }

    public function cover(User $user, $width = null, $height = null)
    {
        $path = $user->cover_photo;
        $filename = $path && Storage::disk()->exists($path) ? Storage::disk()->get($path) : public_path('image/placeholder-wide.png');

        return $this->sendImageResponse($width, $height, $filename,
            Storage::disk()->exists($path) ? Storage::disk()->lastModified($path) : -86400);
    }

    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

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

    public function me()
    {
        $user = $this->user;

        return view('profile.show', compact('user'));
    }

    public function preferences()
    {
        $user = $this->user;
        session(['profile_redirect_path' => '/']);

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
            $tmp = $this->user->profile_photo;
            $this->user->profile_photo = $filename;
            if (File::exists($tmp)) {
                Storage::disk()->delete($tmp);
            }
        }

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $filename = $this->moveFile($file);
            // TODO: Resize image in largest resolution required.
            $tmp = $this->user->cover_photo;
            $this->user->cover_photo = $filename;
            if (File::exists($tmp)) {
                Storage::disk()->delete($tmp);
            }
        }

        $this->validate($request, $this->getRules());

        $this->user->update($request->except(['profile_photo_link', 'cover_photo_link']));

        if (session('maintainer-request') === true) {
            $this->user->is_maintainer = true;
            $this->user->save();
        }

        flash('Changes saved.');
        $this->redirectPath = session('profile_redirect_path');

        return redirect()->intended($this->redirectPath);
    }

    /**
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    public function moveFile(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Uuid::uuid4()->toString() . '.' . $extension;
        Storage::disk()->put($filename, File::get($file));

        return $filename;
    }

    /**
     * @param $width
     * @param $height
     * @param $filename
     * @param $modified
     *
     * @return mixed
     */
    protected function sendImageResponse($width, $height, $filename, $modified)
    {
        if (!is_numeric($width)) {
            $width = null;
        }
        if ($height === null) {
            $height = $width;
        }

        $this->sendImage(response(''), md5($filename), $modified);

        $image = Image::make($filename);

        if ($width !== null) {
            $image->resize($width, $height);
        }

        return $this->sendImage($image->response(), md5($filename), $modified);
    }

    /**
     *
     * Send image function with headers
     *
     * @param \Illuminate\Http\Response $response
     * @param string $etag
     * @param string $modified
     * @param string $browserCache
     *
     * @return bool
     */
    protected function sendImage(Response $response, $etag, $modified = '', $browserCache = '')
    {

        if ($modified == '') {
            $modified = time();
        }

        if ($browserCache == '') {
            $browserCache = 86400000;
        }

        //header('Expires: '.gmdate('D, d M Y H:i:s', time()+$browserCache).' GMT');
        $response->setExpires(Carbon::createFromTimestamp(time() + $browserCache));

        //header('Last-Modified: ' . $lastModified);
        $response->setLastModified(Carbon::createFromTimestamp($modified));

        //header('ETag: ' . $eTag);
        $response->setEtag($etag);

        $notModified = false;

        $lastModified = $response->getLastModified();

        $modifiedSince = \Request::header('If-Modified-Since');

        if (!is_null($modifiedSince)) {


            if ($etags = \Request::header('etag')) {
                $notModified = in_array($response->getEtag(), $etags) || in_array('*', $etags);
            }

            if ($modifiedSince && $lastModified) {
                $notModified = strtotime($modifiedSince) >= $lastModified->getTimestamp() && (!$etags || $notModified);
            }

            if ($notModified) {
                $response->setNotModified();
                abort(304);
            }
        }

        return $response;
    }

    private function getRules()
    {
        if (empty($this->rules)) {
            $this->rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . $this->user->id,
                'username' => 'alpha_dash|unique:users,username,' . $this->user->id,
                'date_of_birth' => 'required|date',
                'gender' => 'required',
                'bio' => 'required',
                'profile_photo_link' => 'url',
                'cover_photo_link' => 'url',
            ];
        }

        return $this->rules;
    }
}