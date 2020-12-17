<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorrentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torrent', function (Blueprint $table) {
            $table->bigIncrements('id');
            //timestamps для таблицы когда была перезаписана или создана запись
            $table->timestamps();
            //какой юзер загрузил торрент
            $table->string('user');
            //какой торрент (путь до него)
            $table->string('torrent');
            //признак загрузки
            $table->boolean('download');
            //notes - заметки
            $table->string('notes');
            //когда был загружен объект из торрента
            $table->dateTime('when_downloaded');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('torrent');
    }
}
