<?php

namespace App\Http\Controllers;

use App\torrent;
use App\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class torrentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showtorrents()
    {
//        if(Auth::user() != null) {
        $tr=DB::table("torrent")->get('*');
//            $tr = torrent::query()->get('*');
            return response()->json([
                'data' => $tr
            ],
                200);
//        } else {
//            return response()->json([
//                'data' => 'Пользователь не аутентифицирован'
//            ],401);
//        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        //при входе в программу
//        $this->middleware('auth:api');
        $torrent = new torrent();
        $user = Auth::user()->name;
        //прописываем в таблице torrent юзера
//        $torrent->user=$torrent->hasOne('App\User', 'name');
        if (torrent::where('user',$user)->count()==0) {
            $torrent->user = $user;
            $torrent->save();
            return "прошёл в torrent";
        }
        return "Не прошёл в torrent";
//        Auth::logout();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //при закачивании торрента
        if($request instanceof File) {

            $torrent = new torrent();
            //записываем файл в переменную
            $file = $request->file('torrent');

            //------------нужна проверка во избежании дублирующих файлов в хранилище!!!------------
            $valid = Validator::make($file->getPathname(), $torrent::$double);

            //Если файл существует и прошёл валидацию, то закидываем его в хранилище
            if ($file && $valid->passes()) {
                //закидываем на жёский диск файл
                Storage::disk('local')->put($file->getPathname(), File::get($file));

                //закидываем имя файла и дату закачки в модель torrent
                $torrent->torrent = $file->getPathname();
                //дата есть в updated_at
                $torrent->save();
            } else {
                //Показать что такой файл уже существует в вёрстке
            }
        } else {
            $string=$request['torrent'];

            $string=substr($string,
                strpos($string,"=http")+1,
                strpos($string,".torrent")-strpos($string,"=http")+7
            );

            Storage::disk('local')->put('public/file1.torrent',file_get_contents($string),'public');

//            if(file_put_contents("myTorrent.torrent", file_get_contents($string))) {
//                return "true";
//            }else {
//                return "false";
//            }

        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\torrent  $torrent
     * @return \Illuminate\Http\Response
     */
    public function show(torrent $torrent)
    {
        //здесь отправим письмо о том, что началась загрузка или нет и что делать
        $user = $torrent->belongsTo('App/User','name');
        $email = $torrent->belongsTo('App/User','email');

        //------------нужна проверка какая нибудь началась загрузка или нет------------

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\torrent  $torrent
     * @return \Illuminate\Http\Response
     */
    public function edit(torrent $torrent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\torrent  $torrent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, torrent $torrent)
    {
        $name = $torrent->belongsTo('App/User','name');
        $email = $torrent->belongsTo('App/User','email');


        if($torrent->download) {
            $message = "Файл ".$torrent->torrent." был успешно загружен ".$torrent->when_downloaded;
        } else {
            $message = "Файл ".$torrent->torrent." не был загружен из-за".$torrent->notes;
        }

        $data=array('name'=>$name, 'body'=>$message);

        Mail::send('mail.messageDownload', $data,
            function($message) use ($name, $email) {
                $message->to($email,$name)->subject('Сообщение о загрузке от torrentForLex');

                $message->from('myTestForApp@gmail.com','George');
            });

        return View('include.main'); //куда то возвращаться...
        //отправить письмо о том, что загрузка завершена
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\torrent  $torrent
     * @return \Illuminate\Http\Response
     */
    public function destroy(torrent $torrent)
    {

        //торрент успешно загружен

    }
}
