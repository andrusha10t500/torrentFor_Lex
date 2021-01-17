<?php

namespace App\Http\Controllers;

use App\Jobs\execJob;
use App\torrent;
use App\Torrents;
use App\User;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\Process\Process;

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
        $tr=DB::table("torrents")->orderBy("created_at") ->get('*');
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
            $string=urldecode($request['torrent']);

            $string=substr($string,
                strpos($string,"=http")+1,
                strpos($string,".torrent")-strpos($string,"=http")+7
            );

            $name = substr(
                $string,
                strripos($string,"/",-1)+1,
                strlen($string)-strripos($string,"/",-1)+1
            );

            $name=urldecode($name);

            Storage::disk('local')->put('/public/'.$name,file_get_contents($string),'public');

            $torrents = new Torrents();

            $torrents->user="admin";
            $torrents->torrent=$name;
            $torrents->save();
//
//            $torrents->when_downloaded=Date('d.m.Y H:i:s');
            if(Torrents::query()
                    ->where('torrent','=', "'". $name . "'")
                    ->count()==0)
            {

                $job=(new execJob(storage_path()."/app/public/".$name, $name))->delay(Carbon::now()->addSecond(5));
                $this->dispatch($job);

                Torrents::query()->where("torrent","=", $name)->update([
    //                    "download" => '0',  //0 - Загрузка началась, null - файла нет, 1 - Загрузка закончилась
                    "notes" => storage_path()."/app/public/".$name  //ссылка на файл
                ]);

            } else {
                return 'Такой торрент уже загружен';
            }
        }
    }

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
    public function deleteTorrent(Request $id)
    {
        $id=$id['id'];
        $name = Torrents::query()->where('id','=',$id)->value("torrent");
//      Удалить из базы
        Torrents::query()->where("id",'=',$id)->delete();
//      Удалить файл торрента
        Storage::disk('local')->delete('/public/'.$name);
//      Удалить скрипт
        File::delete(storage_path(). "/app/scripts/update_".$name.".sh");
//      Убить процесс
        $this->killProcess($name);
    }

    private function killProcess ($name) {

        $process=Process::fromShellCommandline("kill -9 $(ps aux | grep ".$name." | awk '$12!~/color/{print($2)}')");
        $process->run(function ($type, $byte) {
            if(Process::ERR===$type) {
                echo 'ERR: '.$type;
            } else {
                echo 'OUT: '.$byte;
            }
        });
    }
}
