<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;

class Favorites extends Model
{
    const TABLE_NAME = "favorites";

    public static function add($data){
        $added = DB::table(Favorites::TABLE_NAME)->insert($data);
    
        if($adicionou){
            return true;
        }
        else{
            return false;
        }
    }

    public static function remove($id, $user_id){
        $removed = DB::table(Favorites::TABLE_NAME)
        ->where("product_id", $id)
        ->where("user_id", $user_id)
        ->delete();

        if($removed){
            return true;
        }
        else{
            return false;
        }
    }

    public static function isFavoriteAlready($user_id, $product_id){
        $exists = DB::table(Favorites::TABLE_NAME)
        ->where(Favorites::TABLE_NAME . ".user_id", $user_id)
        ->where(Favorites::TABLE_NAME . ".product_id", $product_id)
        ->get();

        if(count($exists) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getFavorites($user_id, $page = 0, $take = 8){
        $qtd = DB::table(Favorites::TABLE_NAME)
        ->join(Product::TABLE_NAME, Product::TABLE_NAME . ".id", Favorites::TABLE_NAME . ".product_id")
        ->where(Favorites::TABLE_NAME . ".user_id", $user_id)
        ->count();

        if($qtd < $take){
            $pages = 0;
        }
        else{
            $rest = $qtd%$take;

            $pages = ($qtd - $rest)/$take;

            if($rest > 0){
                $pages++;
            }
        }

        if($page < 0){
            $page = 0;
        }
        else if($page > ($pages - 1)){
            $page = $pages - 1;
        }

        $favorites = DB::table(Favorites::TABLE_NAME)
        ->join(Product::TABLE_NAME, Product::TABLE_NAME.".id", "=", Favorites::TABLE_NAME. ".product_id")
        ->select(Product::TABLE_NAME.".name", Product::TABLE_NAME.".id", Product::TABLE_NAME.".unique_id")
        ->where(Favorites::TABLE_NAME.".user_id", $user_id)
        ->skip($page * $take)
        ->take($take)
        ->get();

        if(count($favorites) > 0){
            return array(
                'favoritos' => $favorites,
                'paginas' => $pages
            );
        }
        else{
            return array(
                'favoritos' => null,
                'paginas' => 0
            );
        }
    }
}
