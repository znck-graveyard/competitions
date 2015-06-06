<?php namespace App\Http\Controllers;

use App\Contest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use Illuminate\Http\Request;

class ContestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($type)
    {
        $contests = Contest::where('type', $type)->paginate(16);
        return view('contest.indexCategory', comapact('contests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $maintainer_bool = \Auth::user()->is_maintainer;
        if ($maintainer_bool)
            return view('contest.create');
        else
            return view('contest.create_first_time');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
