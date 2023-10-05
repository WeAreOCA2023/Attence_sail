<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersBoss;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;


class BossRegisterController extends Controller
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

    use RegistersBoss;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'companyName' => ['required', 'string', 'max:255'],
            'companyPostCode' => ['required', 'string', 'max:7'],
            'companyAddress' => ['required', 'string', 'max:255'],
            'userName' => ['required', 'string', 'max:255'],
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telephone' => ['required', 'string','max:255', 'unique:users'],
            'is_boss' => ['bool'],
//            'created_at' => ['required', 'datetime'],
//            'updated_at' => ['required', 'datetime'],
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
        // return User::create([
        //     'companyName' => $data['companyName'],
        //     'companyPostCode' => $data['companyPostCode'],
        //     'companyAddress' => $data['companyAddress'],
        //     'userName' => $data['userName'],
        //     'fullName' => $data['fullName'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'telephone' => $data['telephone'],
        //     'is_boss' => $data['is_boss'],

        // ]);

        $company = Company::create([
            'company_name' => $data['companyName'],
            'post_code' => $data['companyPostCode'],
            'address' => $data['companyAddress'],
        ]);
        $userLogin = UserLogin::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user = User::create([
            'userName' => $data['userName'],
            'fullName' => $data['fullName'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'is_boss' => $data['is_boss'],
            'companyID' => $company->id,
            'loginID' => $userLogin->id,
        ]);
        date_default_timezone_set("Asia/Tokyo");


        return $user;
    }
}
