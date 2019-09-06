<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\UserCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'usertype' => $data['userType'],
            
        ]);
        if($data['jobId']!='-1') {
            $company = Company::findOrFail($data['jobId']);
        
            $usercompany = UserCompany::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            ]);
        }

        return $user;
    }

    public function company(Request $request)
    {
        $company = new Company;
        if($request->hiddenValue == 'other') {

            $validator = Validator::make($request->all(), [
                'companyName' => 'required|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $company->companyName = $request->companyName;
            $company->save();
            return redirect('register')->with('recruiter', $company->id);
        }
        else {
            return redirect('register')->with('recruiter', $request->companyId);
        }

        
    }
}
