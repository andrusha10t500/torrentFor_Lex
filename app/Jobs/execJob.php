<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
    public function __construct($name)
    {
        $this->nameTorrent=$name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shell = Process::fromShellCommandline("/usr/bin/transmission-cli -w /mnt/diskG/films/ ".$this->nameTorrent."; sleep 5");
        $shell->run();

    }
}
