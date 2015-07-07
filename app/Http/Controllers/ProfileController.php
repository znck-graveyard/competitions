<?php namespace App\Http\Controllers;

use App\Http\Requests\UserDetailsRequest;
use App\User;
use File;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Rhumsaa\Uuid\Uuid;
use Storage;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ProfileController extends Controller
{
    protected $rules;

    /**
     * @type \App\User
     */
    protected $user;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    function __construct(Guard $auth)
    {
        $this->middleware('auth', ['only' => 'update']);
        $this->user = $auth->user();

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

    public function photo(User $user, $width = null, $height = null)
    {
        if ($height === null) {
            $height = $width;
        }

    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function update(Request $request)
    {
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
                Storage::delete($tmp);
            }
        }

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('profile_photo');
            $filename = $this->moveFile($file);
            // TODO: Resize image in largest resolution required.
            $tmp = $this->user->cover_photo;
            $this->user->cover_photo = $filename;
            if (File::exists($tmp)) {
                Storage::delete($tmp);
            }
        }

        $this->validate($request, $this->rules);

        $this->user->update($request->except(['profile_photo_link', 'cover_photo_link']));

        if (session('maintainer-request') === true) {
            $this->user->is_maintainer = true;
            $this->user->save();
        }

        return redirect()->back();
    }

    /**
     * @param UserDetailsRequest $request
     *
     * @return \Illuminate\View\View

    public function storeFirstTimeContest(UserDetailsRequest $request)
     * {
     *
     * $id = $this->user->id;
     * $moderator = User::find($id);
     * $moderator->first_name = ucfirst($request->get('first_name'));
     * $moderator->last_name = ucfirst($request->get('last_name'));
     * $moderator->email = $request->get('email');
     * $moderator->date_of_birth = $request->get('date_of_birth');
     * $moderator->gender = $request->get('gender');
     *
     * $this->userAttributes($request, $id);
     * $moderator->save();
     *
     * $contest = new Contest();
     * $types = $contest->getTypes();
     * $submission_types = $contest->getSubmissionTypes();
     *
     * return view('contest.create')->with(['types' => $types, 'submission_types' => $submission_types]);
     * }
     */

    /**
     * @param $file
     *
     * @return string
     */
    public function moveFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Uuid::uuid4()->toString() . '.' . $extension;
        Storage::put($filename, File::get($file));

        return $filename;
    }
}