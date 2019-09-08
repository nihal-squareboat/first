<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use App\JobApplication;
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

        $applied = JobApplication::select('job_id')->where('candidate_id', '=', Auth::user()->id)->get()->toArray();

        $jobs = DB::table('jobs')
                ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
                ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
                ->select('jobs.jobTitle', 'jobs.jobDescription', 'companies.companyName', 'jobs.id')
                ->whereNotIn('jobs.id', $applied)
                ->orderBy('companies.companyName', 'asc' )
                ->orderBy('jobs.jobTitle', 'asc')
                ->get();
        
        $appliedJobs = DB::table('job_applications')
                ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
                ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
                ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
                ->select('jobs.jobTitle', 'jobs.jobDescription', 'companies.companyName', 'job_applications.id', 'job_applications.candidate_id')
                ->where('job_applications.candidate_id', '=', Auth::user()->id)
                ->orderBy('companies.companyName', 'asc' )
                ->orderBy('jobs.jobTitle', 'asc')
                ->get();


        if(Auth::user()->usertype == 'candidate') {
            return view('home' ,compact('jobs','appliedJobs'));
        }
        else {
            $jobs = Job::where('user_id',Auth::user()->id)->orderBy('jobTitle', 'asc' )->get();
            return view('home' ,compact('jobs'));
        }
    }
}
