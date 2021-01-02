<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApiController extends Controller
{
    //
    public function index(Request $request) {

        $this->validate($request, [
           'email' => 'required',
           'password' => 'required|min:4'
        ]);
        $email = $request["email"];
        $password = $request["password"];
        if(Auth::attempt(['email' => $email, 'password' => $password]) ){
            $user = Auth::user();
            Auth::login($user, true);
            return redirect()->route('create',['name' => Auth::user()->name]);
        } else {
            return "Пользователь не аутентифицирован";
        }

//        return redirect()->back();
//        return ApiResource::collection(User::query()->where("email","Lex@mail.ru"));
//        return User::query()->where("email", $request["email"] )->get("email");
    }


}
