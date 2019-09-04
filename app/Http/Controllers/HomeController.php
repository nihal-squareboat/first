<?php

namespace App\Http\Controllers;

use App\Job;
use App\Jobapplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $applied = Jobapplied::select('job_id')->where('candidate_id', '=', Auth::user()->id)->get()->toArray();

        $jobs = DB::table('jobs')
                ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
                ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
                ->select('jobs.jobTitle', 'jobs.jobDescription', 'companies.companyName', 'jobs.id')
                ->whereNotIn('jobs.id', $applied)
                ->orderBy('companies.companyName', 'asc' )
                ->orderBy('jobs.jobTitle', 'asc')
                ->get();
        
        $appliedjobs = DB::table('jobapplieds')
                ->join('jobs', 'jobs.id', '=', 'jobapplieds.job_id')
                ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
                ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
                ->select('jobs.jobTitle', 'jobs.jobDescription', 'companies.companyName', 'jobapplieds.id', 'jobapplieds.candidate_id')
                ->where('jobapplieds.candidate_id', '=', Auth::user()->id)
                ->orderBy('companies.companyName', 'asc' )
                ->orderBy('jobs.jobTitle', 'asc')
                ->get();  
        if(Auth::user()->usertype == 'candidate') {
            return view('home' ,compact('jobs','appliedjobs'));
        }
        else {
            $jobs = Job::where('user_id',Auth::user()->id)->orderBy('jobTitle', 'asc' )->get();
            return view('home' ,compact('jobs'));
        }
    }
}
