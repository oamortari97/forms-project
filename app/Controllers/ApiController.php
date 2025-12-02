<?php

namespace App\Controllers;

use App\Controllers\FormController;
use App\Models\FormModel;

class ApiController extends BaseController
{

    private $formController;
    private $formModel;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->formModel = new FormModel();
    }

    public function checkToken()
    {
        $authorizationHeader = $this->request()->getServer('HTTP_AUTHORIZATION');

        if (!$authorizationHeader || strpos($authorizationHeader, 'Bearer ') !== 0) {
            return $this->returnErrorResponse('Token de autenticação ausente ou inválido.', 401);
        }

        $token = substr($authorizationHeader, 7);

        if ($token !== 'token_desenvolvedor') {
            return $this->returnErrorResponse('Token inválido.', 401);
        }

        return true;
    }

    public function login()
    {
        return $this->userController->checkLogin(true);
    }

    public function newUser()
    {
        return $this->userController->newUser(true);
    }

    public function updateUser()
    {
        return $this->userController->editUser(true);
    }

    public function removeUser()
    {
        return $this->userController->deleteUser(true);
    }

    public function getSummaryResponses($formId)
    {
        $questions = [];
        $formattedData = []; // Array para armazenar os dados formatados
    
        $formData = $this->formModel->returnResponses($formId);
    
        foreach ($formData as $item) {
            if (!isset($questions[$item['question_text']])) {
                $questions[$item['question_text']] = [];
            }
    
            $questions[$item['question_text']][$item['option_text']] = $item['response_count'];
        }
    
        // Transformar o array de perguntas e respostas em um formato tabular
        foreach ($questions as $question => $responses) {
            foreach ($responses as $response => $count) {
                $formattedData[] = [
                    'Pergunta' => $question,
                    'Resposta' => $response,
                    'Contagem' => $count
                ];
            }
        }

        header('Content-Type: application/json; charset=utf-8');

        http_response_code(200);

        echo json_encode($formattedData, JSON_UNESCAPED_UNICODE);
        exit(0);
    }
}
