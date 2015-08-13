<?php namespace App\Http\Controllers;

use App\User;
use App\Team;

class HomeController extends Controller
{
    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }

    public function faq()
    {
        return view('faq');
    }

    public function about()
    {
        return view('about');
    }

    public function terms()
    {
        return view('terms');
    }

    /**
     * @param $username
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function userProfile($username)
    {
        $user = User::whereUsername($username);
        if (is_null($user)) {
            return redirect('/');
        } else {
            $entries = $user->entriesSubmitted();
            $teams = $user->teams();
            foreach ($teams as $team) {

                $team_entry = $team->entriesSubmitted();
                $entries = array_merge($entries, $team_entry);
            }
            $paginator = $entries->epaginate(16);
            $user_entries = $paginator->getCollection();
            $fractal = new Manager();
            $resource = new \League\Fractal\Resource\Collection($user_entries, new EntryTransformer());
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

            //TODO  don't know how to access this with view
            // return view('user.profile', compact('user','entries'));
        }

    }
}
