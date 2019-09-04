<?php

namespace App\Http\Controllers;
use Mail;
use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MailController extends Controller {

   public function applied_mail($id) {

        $appliedjobs = DB::table('jobs')
            ->join('usercompanies', 'jobs.user_id', '=', 'usercompanies.user_id')
            ->join('companies', 'companies.id', '=', 'usercompanies.company_id')
            ->join('users','users.id', '=', 'usercompanies.user_id')
            ->select('jobs.jobTitle', 'companies.companyName', 'users.email','users.name')
            ->where('jobs.id', '=', $id)
            ->first();

        $candidate = DB::table('users')
                ->select('name', 'email')
                ->where('id', '=', Auth::user()->id)
                ->first();


        $recruiterName=$appliedjobs->name;
        $recruiterEmail=$appliedjobs->email;
        $name=$candidate->name;
        $email_id=$candidate->email;
        $jobTitle=$appliedjobs->jobTitle;
        $companyName=$appliedjobs->companyName;
        
        $data = array('name' => $name, 'title' => $jobTitle, 'companyName' => $companyName);
        
        Mail::send('mail', $data, function($message) use ($name,$email_id) {
                $message->to($email_id, $name)
                ->subject('Applied Successfully');
        });

        $data = array('name' => $name, 'recruiterName' => $recruiterName, 'email' => $email_id, 'jobTitle' => $jobTitle);

        Mail::send('recruitermail', $data, function($message) use ($recruiterName,$recruiterEmail) {
            $message->to($recruiterEmail, $recruiterName)
            ->subject('Application Recieved');
        });

        Session::put('applied','Applied');
        return redirect()->route('home');
   }
}