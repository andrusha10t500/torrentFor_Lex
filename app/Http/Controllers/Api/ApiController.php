<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function signUpPost(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        //создание экземпляра класса User()
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

//        $user->name = $request['userName'];
//        $user->email = $request['email'];
//        $user->password = bcrypt($request['password']);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

//        $user->save();

//        Auth::login($user,true);

        return response()->json([
            'success' => $success
            ]
        );
    }

    public function signInPost(Request $request) {

        $this->validate($request, [
           'email' => 'required',
           'password' => 'required|min:4'
        ]);
        $email = $request["email"];
        $password = $request["password"];

        if(Auth::attempt(
            [
                'email' => $email,
                'password' => $password
            ],true)
        ){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            Auth::login($user, true);
            return response()->json(['success' => $success],200);
//            return redirect()->route('create', ['success' => $success]);
        } else {
//            return redirect()->back(302);
        }
    }


}
