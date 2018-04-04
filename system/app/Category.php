<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    const FIELDS = ['name', 'id'];
    const TABLE_NAME = "categories";

    public static function getCategories(){
        $categories = DB::table(Category::TABLE_NAME)
        ->select(Category::FIELDS)
        ->get();

        if(count($categories) > 0){
            return $categories;
        }
        else{
            return null;
        }
    }

    public static function saveCategory($data){
        $added = DB::table(Category::TABLE_NAME)
        ->insert($data);

        if($added){
            return true;
        }
        else{
            return false;
        }
    }
}
