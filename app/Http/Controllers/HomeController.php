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

    /**
     * @param $username
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function userProfile($username)
    {
        $user = User::whereUsername($username);
        if (is_null($user)) {
            return redirect('/');
        } else {
            return view('profile.blade.php',compact('user'));
        }

    }

    /**
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function userEntries($user)
    {
        $entries = $user->entriesSubmitted();
        $teams = $user->teams();
        foreach ($teams as $team) {
            $team_entry = $team->entriesSubmitted();
            $entries = array_merge($entries, $team_entry);
        }
        $paginator = $entries->paginate(16);
        $user_entries = $paginator->getCollection();
        $fractal = new Manager();
        $resource = new \League\Fractal\Resource\Collection($user_entries, new EntryTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return response()->json($fractal->createData($resource)->toArray());

    }
}
