<?php namespace App\Http\Controllers;

use App\User;

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

    public function userProfile($username)
    {
        $user = User::whereUsername($username);
        if (is_null($user)) {
            return redirect('/');
        }
        else {
            return view('user.profile',compact('user'));
        }

    }
}
