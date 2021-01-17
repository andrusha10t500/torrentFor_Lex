<?php

namespace App\Jobs;

use App\Torrents;
use Illuminate\Bus\Queueable;
use Illuminate\Database\QueryException;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class execJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $nameTorrent;
    protected $name;

    public function __construct($nameTorrent, $name)
    {
        $this->nameTorrent=$nameTorrent;
        $this->name=$name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $scriptContent = '#!/bin/bash

DBUSER=root
DBPASSWORD=qtr67uy
DATABASE=torrent                        

mysql -u$DBUSER -p$DBPASSWORD -D$DATABASE -e "UPDATE torrents SET download=1, when_downloaded=now() WHERE torrent=\''.$this->name.'\'"
        ';

        Storage::disk('local')->put('/scripts/update_'.$this->name.'.sh',$scriptContent,'public');

        $scriptPath = storage_path()."/app/scripts/update_".$this->name.".sh";

        $shell = Process::fromShellCommandline(
"
        chmod +x $scriptPath
        i=51413;
        while [ \$i -le 51433 ]
          do
            IP=\$(netstat -n | grep \$i | tail -n 1 | awk '{print(\$4)}')
            PORT=\${IP##*:}
            if [ -z \"\$PORT\" ]
              then 
                /usr/bin/transmission-cli -p \$i -w /home/\$USER/ '$this->nameTorrent' -f $scriptPath;
                break
            fi
           i=\$(( i+1 ))
        done
        ");

        try {
            $shell->mustRun(
                function($type, $buffer) {

                    if (Process::ERR === $type) {
                        echo 'ERR > '.$buffer;
                    } else {
                        echo 'OUT > '.$buffer;
                    }
                }
            );
            echo 'try mustRun: '.$shell->getOutput();
        } catch (ProcessFailedException $e) {
            echo 'Exception mustRun: '.$e->getMessage();
        }



        if($shell->getStatus()==Process::STATUS_STARTED) {
            echo 'Status: Started';
        } else if($shell->getStatus()==Process::STATUS_TERMINATED) {
            echo 'Status: Terminated';
            try {
                DB::table('torrents')->
                where('torrent', '=', "'". $this->name . "'")->
                update([
                    'download' => 'null'
                ]);
            } catch (QueryException $e) {
                echo 'errorDB: '.$e->getMessage();
            }
        }

        if($shell->isRunning() || $shell->isStarted()){

            try {
                DB::table('torrents')->
                where('torrent', '=', "'" . $this->name . "'" )->
                update([
                    'download' => '0'
                ]);
            } catch (QueryException $e) {
                echo 'errorDB: '.$e->getMessage();
            }

        } else if($shell->isSuccessful()) {

            try {
                DB::table('torrents')->
                where('torrent', '=', "'" . $this->name . "'")->
                update([
                    'download' => '1'
                ]);
            } catch (QueryException $e) {
                echo 'errorDB: '.$e->getMessage();
            }
        } else if(!$shell->isSuccessful()){

            try {
                DB::table('torrents')->
                where('torrent', '=', "'" . $this->name . "'")->
                update([
                    'download' => 'null'
                ]);
            } catch (QueryException $e) {
                echo 'errorDB: '.$e->getMessage();
            }
        }

    }
    public function failed($exception = null)
    {
        echo $exception;
    }
}
