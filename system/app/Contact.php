<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const TABLE_NAME = "contact";
    
    public static function add($data){
        $added = DB::table(Contact::TABLE_NAME)->insert($data);

        if($added){
            return true;
        }
        else{
            return false;
        }
    }
}
