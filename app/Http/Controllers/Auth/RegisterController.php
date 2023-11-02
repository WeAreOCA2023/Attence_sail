<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Check if the input password matches the company_password in company_table
     */
    public function unhash($inputPassword)
    {
        $companyCode = User::where('user_id', Auth::id())->first()->company_id;
        $hashedPasswordFromDb = Company::where('company_code', $companyCode)->first()->company_password;
        if (Hash::check($inputPassword, $hashedPasswordFromDb)) {
            return true;
        }
        return false;
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
            'userName' => ['required', 'string', 'max:255'],
            'companyCode' => ['required', 'string', 'max:255', 'matches_company_code_and_password'],
            'companyPassword' => ['required', 'string', 'max:255'],
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_logins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telephone' => ['required', 'string','max:255', 'unique:users'],
            'is_boss' => ['bool'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userLogin = UserLogin::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        

        $user = User::create([
            'user_id' => $userLogin->id,
            'user_name' => $data['userName'],
            'full_name' => $data['fullName'],
            'telephone' => $data['telephone'],
            // 'company_id' => function() use ($data) {
            //     $company = Company::where('company_code', $data['companyCode'])->first();
            //     return $company->id;
            // },
            'company_id' => Company::where('company_code', $data['companyCode'])->first()->id,
            'is_boss' => $data['is_boss'],
        ]);



        return $userLogin;
    }
}
