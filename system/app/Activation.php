<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;
use App\User;

use DB;

class Activation extends Model
{
    const TABLE_NAME = 'activation';
    const URL = "http://www.crescendoepassando.com.br/ativarconta/";

    public static function activate($token){
        $activation = Activation::getActivation($token);

        // se não existe nenhum token igual
        if($activation == null){
            return false;
        }

        // var_dump($activation);

        // Pega o usuario em questão
        $usuario = User::grabUserById($activation['user_id']);

        if($usuario != null){
            $usuario['activated'] = "yes";
        }
        else{
            return false;
        }


        if(!User::updateUser($usuario, $activation['user_id'])){
            return false;
        }

        return Activation::deleteActivation($activation['id']);
    }

    public static function generateActivationToken($user_id, $email, $username){
        $string = password_hash($user_id, PASSWORD_BCRYPT);
        $string = str_ireplace("$", "", $string);
        $string = str_ireplace("/", "", $string);
        $string = str_ireplace("\\", "", $string);
        $string = str_ireplace(".", "", $string);
        $string = str_ireplace(",", "", $string);

        $data = array(
            'user_id' => $user_id,
            'token' => $string
        );

        $added = Activation::saveActivation($data);

        if($added){
            Mail::to($email)->send(new AccountCreated($username, Activation::URL . $string));
            return true;
        }
        else{
            return false;
        }
    }

    public static function saveActivation($data){
        $added = DB::table(Activation::TABLE_NAME)
        ->insert($data);

        return $added;
    }

    private static function getActivation($token){
        $activation = DB::table(ACTIVATION::TABLE_NAME)
        ->select('id','user_id', 'token')
        ->where('token', $token)
        ->get();

        if(count($activation) > 0){
            return (array)$activation[0];
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

    public static function isUserActivated($email){
        $user = DB::table(User::TABLE_NAME)
        ->where('activated', 'yes')
        ->where('email', $email)
        ->get();

        if(count($user) > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
