<?php

namespace App\Http\Controllers;

use App\User;
use App\torrent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(Request $request) {
        //Валидация полей ввода
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        //создание экземпляра класса User()
        $user = new User();
        $user->name = "Lex_L";
        $user->email = $request['email'];
        $user->password  = bcrypt($request['password']);

        $user->save();

        Auth::login($user);
    }
}

