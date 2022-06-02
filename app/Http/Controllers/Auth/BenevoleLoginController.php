<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class BenevoleLoginController extends Controller
{
    protected $guard = "benevole";
    use AuthenticatesUsers;


    public function __construct(){
        $this->middleware("guest:benevole")->except("logout");
    }

    public function showLoginForm(){
        if(Auth::guard("donneur")->check()){
            return redirect("/");
        }
        return view("auth.login");
    }

    public function login(Request $request){
        //Validate:
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ]);
        //Login:
        if(Auth::guard("benevole")->attempt(["username" => $request->username,"password" => $request->password],$request->remember)){
            return redirect()->intended("/");
        }
        return redirect()->back();
    }

    public function logout(){
        Auth::guard("benevole")->logout();
        return redirect()->intended("/login");
    }
}
