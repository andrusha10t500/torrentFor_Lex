<?php

namespace App\Http\Controllers;

use App\User;
use App\torrent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signup(Request $request) {
        //Валидация полей ввода
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        //создание экземпляра класса User()
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];

        $user->save();
    }
}

