<?php namespace App\Http\Controllers;

use App\Contest;
use App\Http\Requests;
use App\Judge;
use App\User;
use App\UserAttribute;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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
        $this->middleware('auth', ['only' => ['create', 'update', 'edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $type
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
        $user=User::find($this->user->id);

            $maintainer_bool = $user->is_maintainer;
            if ($maintainer_bool)
                return view('contest.create');
            else
                return view('contest.create_first_time');

    }

    /**
     * @param Requests\UserDetailsRequest $request
     * @return \Illuminate\View\View
     */
    public function storeFirstTime(Requests\UserDetailsRequest $request)
    {

        $id = $this->user->id;
        $moderator = User::find($id);
        $moderator->first_name = ucfirst($request->get('first_name'));
        $moderator->last_name = ucfirst($request->get('last_name'));
        $moderator->email = $request->get('email');
        $moderator->date_of_birth = $request->get('date_of_birth');
        $moderator->gender = $request->get('gender');

        $this->userAttributes($request, $id);
        return view('contest.create');
    }


    /**
     * Entering User Attributes
     * @param Requests\UserDetailsRequest $request
     * @param $id
     */
    public function userAttributes(Requests\UserDetailsRequest $request, $id)
    {
        $user_attribute = [];
        $short_bio = $request->get('short_bio');
        $user_attribute_short_bio = [
            'user_id' => $id,
            'key' => 'short_bio',
            'value' => $short_bio
        ];
        $user_attributes[] = $user_attribute_short_bio;

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getFilename() . '.' . $extension;
            Storage::disk('local')->put($filename, File::get($file));
            $user_attribute_profile_pic = [
                'user_id' => $id,
                'key' => 'profile_pic',
                'value' => $filename
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
                'key' => 'cover_image',
                'value' => $filename
            ];
            $user_attributes[] = $user_attribute_profile_pic;
        }

        if ($request->has('facebook_username')) {
            $user_attribute_facebook = [
                'user_id' => $id,
                'key' => 'facebook_username',
                'value' => $request->get('facebook_username')
            ];
            $user_attributes[] = $user_attribute_facebook;

        }
        if ($request->has('twitter_username')) {
            $user_attribute_twitter = [
                'user_id' => $id,
                'key' => 'twitter_username',
                'value' => $request->get('twitter_username')
            ];
            $user_attributes[] = $user_attribute_twitter;
        }
        if ($request->has('instagram_username')) {
            $user_attribute_instagram = [
                'user_id' => $id,
                'key' => 'instagram_username',
                'value' => $request->get('instagram_username')
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
     * @param Requests\CreateContestRequest $request
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
     * @param  int $id
     * @param Requests\CreateContestRequest $request
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
            $contest_id=$contest->id;
            if((isset($judge['user_id']))){
                $user_id=$judge['user_id'];
            }
            else{
                $user_id=null;
            }
            DB::table('judges')->insert(
                array(
                    'contest_id' => $contest->id,
                    'user_id' =>$user_id,
                    'link' => $judge['link'],
                    'email' => $judge['email'],
                    'judge_string' => $judge_string
                )
            );

            $whole_judge_link = 'contest/'.$contest_id.'/'.$judge_string;
            \Mail::queue('emails.judge', ['whole_judge_link' => $whole_judge_link, 'contest' => $contest->name], function ($message)
            use ($judge)
            {
                $email = $judge['email'];
                $message->to($email)->subject('Judgement Link');
            });
        }


        return $contest;


    }


}
