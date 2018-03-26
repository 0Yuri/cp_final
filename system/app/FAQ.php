<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    const TABLE_NAME = "faq";

    public static function add($question){        
        $added = DB::table(FAQ::TABLE_NAME)
        ->insert($question);

        if($added){
            return true;
        }
        else{
            return false;
        }
    }

    public static function remove($id){
        $deleted = DB::table(FAQ::TABLE_NAME)
        ->where("id", $id)
        ->delete();

        if($deleted){
            return true;
        }
        else{
            return false;
        }
    }

    public static function updateFAQ($data){
        $updated = DB::table(FAQ::TABLE_NAME)
        ->where("id", $data['id'])
        ->update($data);

        if($updated){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getQuestions($type){
        $perguntas = DB::table(FAQ::TABLE_NAME)
        ->where("type", $type)
        ->get();

        if(count($perguntas) > 0){
            return $perguntas;
        }
        else{
            return null;
        }
    }
}
