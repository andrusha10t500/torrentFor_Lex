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
    public function signUpPost(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        //создание экземпляра класса User()
        $user = new User();
        $user->name = $request['userName'];
        $user->email = $request['email'];
        $user->password  = bcrypt($request['password']);

        $user->save();

        Auth::login($user,true);

        return response()->json([
            'data' => 'Пользователь зарегистрирован и вошёл в систему'
        ]);
    }

    public function signInPost(Request $request) {

        $this->validate($request, [
           'email' => 'required',
           'password' => 'required|min:4'
        ]);
        $email = $request["email"];
        $password = $request["password"];
        if(Auth::attempt(['email' => $email, 'password' => $password],true) ){
            $user = Auth::user();
            Auth::login($user, true);
            return redirect()->route('create',['name' => $user->name]);
        } else {
            return "Пользователь не аутентифицирован";
        }
    }


}
