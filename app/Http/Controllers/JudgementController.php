<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Judge;
use Carbon\Carbon;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class JudgementController extends Controller
{


    /**
     * @param $id
     * @param $judge_string
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function checkLink($id, $judge_string)
    {

        if (!$judge_string) {
            throw new AccessDeniedException;
        }
        $judge = Judge::where('judge_string', '=', $judge_string)->first();
        if (!$judge) {
            throw new AccessDeniedException;
        } else {
            $contest = $judge->contest();
            if (($id == $contest->id) && (Carbon::now() < $contest->end_date)) {
                $entries = $contest->submissions();
                return view('contest.judge', compact('contest', 'entries'));
            } else {
                flash()->warning('Access Denied. Link Expired.');
            }
        }
        return redirect('home');

    }

    public function contestJudge($id)
    {
        $judge=Judge::where('user_id','=',$id);
        if($judge){
            $contest=$judge->contest();
            if (Carbon::now() < $contest->end_date) {
                $entries = $contest->submissions();
                return view('contest.judge', compact('contest', 'entries'));
            } else {
                flash()->warning('Access Denied. Link Expired');
            }

        }
        else
        {
            flash()->warning('Access Denied');
        }
        return redirect()->back();

    }


}
