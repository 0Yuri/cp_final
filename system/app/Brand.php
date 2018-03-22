<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Brand extends Model
{
    const FIELDS = ['name', 'id'];
    const TABLE_NAME = "brands";

    public static function getBrands(){
        $brands = DB::table(Brand::TABLE_NAME)
        ->select(Brand::FIELDS)
        ->get();

        if(count($brands) > 0){
            return $brands;
        }
        else{
            return null;
        }
    }

    public static function saveBrand($data){
        $added = DB::table(Brand::TABLE_NAME)
        ->insert($data);

        if($added){
            return true;
        }
        else{
            return false;
        }
    }
}
