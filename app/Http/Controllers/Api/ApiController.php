<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function index(Request $request) {

        $email = $request["email"];
//        return ApiResource::collection(User::query()->where("email","Lex@mail.ru"));
        return User::query()->where("email",$request["email"] )->get("email");
    }
}
