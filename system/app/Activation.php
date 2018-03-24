<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use DB;

class Activation extends Model
{
    const TABLE_NAME = 'activation';

    public static function activate($token){
        $activation = Activation::getActivation($token);
        
        // se não existe nenhum token igual
        if($activation == null){
            return false;
        }

        // Pega o usuario em questão
        $usuario = User::grabUserById($activation->user_id);

        if($usuario == null){
            return false;
        }

        $usuario['activated'] = "yes";

        if(!User::updateUser($usuario)){
            return false;
        }

        return Activation::deleteActivation($activation->id);
    }

    private static function getActivation($token){
        $activation = DB::table(ACTIVATION::TABLE_NAME)
        ->select('id','user_id', 'token')
        ->where('token', $token)
        ->get();

        if(count($activation) > 0){
            return $activation[0];
        }
        else{
            return null;
        }
    }

    private static function deleteActivation($id){
        $deleted = DB::table(ACTIVATION::TABLE_NAME)
        ->where('id', $id)
        ->delete();

        if($deleted){
            return true;
        }
        else{
            return false;
        }
    }
}
