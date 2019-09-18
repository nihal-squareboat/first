<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jobTitle' => 'required|max:255',
            'jobDescription' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $job = new Job;

        $job->jobTitle = $request->jobTitle;
        $job->jobDescription = $request->jobDescription;
        $job->user_id = Auth::user()->id;
        $job->save();
        Session::put('success','Added job successfully');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applicants = DB::table('job_applications')
                ->join('users', 'users.id', '=', 'job_applications.candidate_id')
                ->select('users.name', 'users.email')
                ->where('job_applications.job_id', '=', $id)
                ->orderBy('users.name', 'asc' )
                ->orderBy('users.email', 'asc')
                ->paginate(15);
            return view('applicants' ,compact('applicants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $job = Job::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'jobTitle' => 'required|max:255',
            'jobDescription' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->with('edit', $id)
                        ->withInput();
        }

        $job->jobTitle = $request->jobTitle;
        $job->jobDescription = $request->jobDescription;

        $job->save();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        Session::put('deleted','Job deleted successfully');
        return redirect()->route('home');
    }
}
