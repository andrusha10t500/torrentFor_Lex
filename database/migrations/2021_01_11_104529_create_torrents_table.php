<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torrents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            //какой юзер загрузил торрент
            $table->string('user')->nullable();
            //какой торрент (путь до него)
            $table->string('torrent')->nullable();
            //признак загрузки
            $table->boolean('download')->nullable();
            //notes - заметки
            $table->string('notes')->nullable();
            //когда был загружен объект из торрента
            $table->dateTime('when_downloaded')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('torrents');
    }
}
