<?php

namespace App\Listeners;

use App\Event\EventEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventEmailListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventEmail  $event
     * @return void
     */
    public function handle(EventEmail $messages)
    {
        $appliedJobs = DB::table('jobs')
            ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
            ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
            ->join('users','users.id', '=', 'usercompanies.user_id')
            ->select('jobs.jobTitle', 'companies.companyName', 'users.email','users.name')
            ->where('jobs.id', '=', $messages->message)
            ->first();

        $candidate = DB::table('users')
                ->select('name', 'email')
                ->where('id', '=', Auth::user()->id)
                ->first();

        $recruiterName=$appliedJobs->name;
        $recruiterEmail=$appliedJobs->email;
        $name=$candidate->name;
        $emailId=$candidate->email;
        $jobTitle=$appliedJobs->jobTitle;
        $companyName=$appliedJobs->companyName;
        
        $data = array('name' => $name, 'title' => $jobTitle, 'companyName' => $companyName);
        
        Mail::send('mail', $data, function($message) use ($name,$emailId) {
                $message->to($emailId, $name)
                ->subject('Applied Successfully');
        });
        
        $data = array('name' => $name, 'recruiterName' => $recruiterName, 'email' => $emailId, 'jobTitle' => $jobTitle);

        Mail::send('recruitermail', $data, function($message) use ($recruiterName,$recruiterEmail) {
            $message->to($recruiterEmail, $recruiterName)
            ->subject('Application Recieved');
        });
        
        Session::put('applied','Applied');
        return;
    }
}
