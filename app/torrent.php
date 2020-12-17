<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class torrent extends Model
{
    public function torrent(){
        return $this->belongsTo('App/User');
    }

    public static $double = array ('torrent' => 'required|unique');

    //Проверка на существование поля
    public function getValue($fieldName) {

        $validField=false;
        $query = 'SHOW COLUMNS FROM '.$this->table;
        foreach (DB::select($query) as $column) {
            if($fieldName==$column->Field) {
                $validField=true;
                break;
            }
        }

        if($validField) {
            return $this->$fieldName;
        } else {
            return false;
        }
    }

}
