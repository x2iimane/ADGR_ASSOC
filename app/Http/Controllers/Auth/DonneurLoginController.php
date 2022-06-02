<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DonneurLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = "donneur";

    public function __construct(){
        $this->middleware("guest:donneur")->except("logout");
    }

    public function showLoginForm(){
        if(Auth::guard("benevole")->check()){
            return redirect()->intended("/");
        }
        return view("auth.donneur-login");
    }

    public function login(Request $request){
        //Validate:

        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ]);
        //Login:
        if(Auth::guard("donneur")->attempt(["username" => $request->username,"password" => $request->password],$request->remember)){
            return redirect()->intended("/");
        }
        return redirect()->back();
    }

    public function logout(){
        Auth::guard("donneur")->logout();
        return redirect()->intended("/donneur/login");
    }
}
