<?php

namespace App\Http\Controllers;

use App\FAQ;

class HelpController extends Controller
{
    
    public function createQuestion(){
        $data = $this->get_post();

        $status = FAQ::add($data);

        if(!$status){
            $this->return->setFailed("Não foi possível criar sua pergunta.");
            return;
        }
    }

    public function removeQuestion(){
        $data = $this->get_post();

        $status = FAQ::remove($data['id']);

        if(!$status){
            $this->return->setFailed("Ocorreu um erro ao deletar a pergunta.");
            return;
        }
    }

    public function updateQuestion(){
        $data = $this->get_post();

        $status = FAQ::updateQuestion($data);

        if(!$status){
            $this->return->setFailed("Ocorreu um erro ao editar a pergunta.");
            return;
        }
    }

    public function getQuestions($type){
        $questions = FAQ::getQuestions($type);

        if($questions){
            $this->return->setObject($questions);
            return;
        }
        else{
            $this->return->setFailed("Nenhuma pergunta foi encontrada.");
            return;
        }
    }
}
