<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contact extends Model
{
    const TABLE_NAME = "contacts";
    
    public static function add($data){
        $added = DB::table(self::TABLE_NAME)->insert($data);

        if($added){
            return true;
        }
        else{
            return false;
        }
    }

    public static function updateEntry($user_id, $data){
        $updated = DB::TABLE_NAME(self::TABLE_NAME)
        ->update($data)
        ->where('user_id', $user_id);

        if($updated){
            return true;
        }
        else{
            return false;
        }
    }

    public static function deleteEntry($name_id){
        $deleted = DB::TABLE_NAME(self::TABLE_NAME)
        ->where('user_id', $name_id)
        ->delete();

        if($deleted){
            return true;
        }
        else{
            return false;
        }
    }
}
