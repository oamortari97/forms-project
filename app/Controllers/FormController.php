<?php

namespace App\Controllers;

use App\Models\FormModel;

use App\Controllers\UserController;
use App\Models\UserModel;

class FormController extends BaseController
{
    protected $formModel;
    protected $userModel;
    protected $userController;

    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->userModel = new UserModel();
        $this->userController = new UserController();
    }

    public function mainFormsView()
    {
        $forms = $this->formModel->getForms();

        return $this->returnDefaultTemplate('Forms/formularios', ['formularios' => $forms], [base_url('assets/js/forms.js')]);
    }

    public function addFormView()
    {
        return view('Forms/novo');
    }

    public function newForm($api = false)
    {
        $postData = [
            'name' => $this->returnPost('nome'),
            'description' => $this->returnPost('descricao'),
            'starts' => $this->returnPost('data_inicial'),
            'ends' =>  $this->returnPost('data_final'),
            'author_id' => $this->session()->get('usuario')['user_id'] ?? $this->returnPost('autor_id'),
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (date('Y-m-d', strtotime($postData['ends'])) < date('Y-m-d', strtotime($postData['starts']))) {
            $msg = 'A data final não pode ser menor que a data inicial.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (date('Y-m-d', strtotime($postData['ends'])) < date('Y-m-d')) {
            $msg = 'A data final não pode ser menor que a data atual.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $postData['share'] = empty($this->returnPost('acesso_externo')) ? 0 : 1;

        $newForm = $this->formModel->newForm($postData);

        if (!$newForm) {
            $msg = 'Não foi possível concluir sua solicitação.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Formulário cadastrado com sucesso.');

        return redirect()->to(base_url('formularios/modelar/' . $newForm));
    }

    public function editForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (!$this->formModel->returnFormId($postData['id'])) {
            $msg = 'O formulário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $editableFields = [
            'name' => $this->returnPost('nome'),
            'description' => $this->returnPost('descricao'),
            'starts' => $this->returnPost('data_inicial'),
            'ends' =>  $this->returnPost('data_final'),
            'ends' =>  $this->returnPost('data_final'),
            'share' => $this->returnPost('acesso_externo') ?? '0',
            'posted' => $this->returnPost('postar') ?? '0',
        ];

        foreach ($editableFields as $key => $fieldValue) {
            if (!empty($fieldValue) || $fieldValue == '0') {
                $postData['update'][$key] = $fieldValue;
            }
        }

        $this->formModel->updateForm($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Formulário atualizado com sucesso.');
        return redirect()->route('formularios');
    }

    public function updateForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (!$this->formModel->returnFormId($postData['id'])) {
            $msg = 'O formulário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $editableFields = [
            'ends' =>  $this->returnPost('data_final'),
            'posted' => $this->returnPost('form_postado') ?? '0',
        ];

        foreach ($editableFields as $key => $fieldValue) {
            if (!empty($fieldValue) || $fieldValue == '0') {
                $postData['update'][$key] = $fieldValue;
            }
        }

        $this->formModel->updateForm($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Formulário atualizado com sucesso.');
        return redirect()->route('formularios');
    }

    public function deleteForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (!$this->formModel->returnFormId($postData['id'])) {
            $msg = 'O formulário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $this->formModel->removeForm($postData['id']);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Formulário removido com sucesso.');
        return redirect()->route('formularios');
    }

    public function modellingForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id'),
            'questions' => $this->returnPost('questoes')
        ];

        if (empty($postData['questions'])) {
            return redirect()->route('formularios');
        }

        $this->formModel->removeQuestions($postData['id']);

        foreach ($postData['questions'] as $question) {
            $questionData = [
                'form_id' => $postData['id'],
                'question_type' => $question['type'],
                'question_text' => $question['text']
            ];

            $existingQuestion = $this->formModel->returnDuplicateQuestion($postData['id'], $question['type'], $question['text']);

            if ($existingQuestion) {
                $insertQuestion = $existingQuestion['id'];
                $this->formModel->updateQuestion($insertQuestion, $questionData);
            } else {
                $insertQuestion = $this->formModel->addQuestion($questionData);
            }

            if ($question['type'] !== 'text') {
                foreach ($question['options'] as $option) {
                    $optionData = [
                        'question_id' => $insertQuestion,
                        'option_text' => empty($option['text']) ? (string) '0 ' : $option['text'],
                        'option_true' => $option['true'] === 'true' ? 1 : 0
                    ];

                    $existingOption = $this->formModel->returnDuplicateOption($insertQuestion, $option['text']);
                    if ($existingOption) {
                        $this->formModel->updateOption($existingOption['id'], $optionData);
                    } else {
                        $this->formModel->addOption($optionData);
                    }
                }
            }
        }

        if ($api) {
            return $this->returnSuccessResponse($this->returnPost('questoes'));
        }

        $msg = 'Formulário salvo com sucesso!';

        return $this->setSuccessAlert($msg);
    }

    public function editFormView()
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $form = $this->formModel->getFormById($postData['id']);

        if (empty($form)) {
            $msg = 'Formulário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        return view('Forms/editar', ['formulario' => $form[0]]);
    }

    public function modellingFormView($formId)
    {
        if (empty($formId)) {
            return redirect()->route('formularios');
        }

        $formData = $this->formModel->getFormById($formId);
        $responseCount = $this->formModel->getForms($formId);

        if (empty($formData)) {
            $msg = 'Formulário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        foreach ($formData as $row) {
            if (!isset($formArray['id'])) {
                $formArray['id'] = $row['form_id'];
                $formArray['name'] = $row['form_name'];
                $formArray['description'] = $row['form_description'];
                $formArray['posted'] = $row['posted'];
                $formArray['questions'] = [];
            }

            if ($row['question_id']) {
                if (!isset($formArray['questions'][$row['question_id']])) {
                    $formArray['questions'][$row['question_id']] = [
                        'id' => $row['question_id'],
                        'type' => $row['question_type'],
                        'text' => $row['question_text'],
                        'options' => []
                    ];
                }

                if ($row['option_text']) {
                    $formArray['questions'][$row['question_id']]['options'][] = [
                        'text' => $row['option_text'],
                        'true' => $row['option_true']
                    ];
                }
            }
        }

        if (!empty($formArray['questions'])) {
            return $this->returnDefaultTemplate('Forms/editar-modelo', ['formulario' => $formArray, 'respostas' => $responseCount], [base_url('assets/js/editModelling.js')]);
        } else {
            return $this->returnDefaultTemplate('Forms/modelar', ['formulario' => $formArray], [base_url('assets/js/modelling.js')]);
        }
    }

    public function deleteFormView()
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $form = $this->formModel->getFormById($postData['id']);

        if (empty($form)) {
            $msg = 'O formulário informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        return view('Forms/apagar', ['formulario' => $form[0]]);
    }

    public function postForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (!$this->formModel->returnFormId($postData['id'])) {
            $msg = 'O formulário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $postData['update']['posted'] = 1;

        $this->formModel->updateForm($postData);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Formulário publicado com sucesso.');
        return redirect()->route('formularios');
    }

    public function postFormView()
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $form = $this->formModel->returnFormId($postData['id']);

        if (empty($form)) {
            $msg = 'O formulário informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        return view('Forms/publicar', ['formulario' => $form]);
    }

    public function shareFormView($formId)
    {

        $form = $this->formModel->returnFormId($formId);

        if (!$form) {
            $msg = 'O formulário informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $access = $this->formModel->getExternalByForm($formId);

        return $this->returnDefaultTemplate('Forms/compartilhar', ['formulario' => $form, 'acessos' => $access], [base_url('assets/js/sharing.js')]);
    }

    public function newShareFormView()
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $form = $this->formModel->returnFormId($postData['id']);

        if (empty($form)) {
            $msg = 'O formulário informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $access = $this->formModel->getExternalByForm($postData['id'], true);

        return view('Forms/compartilhar-novo', ['formulario' => $form, 'acessos' => $access]);
    }


    public function shareForm($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id'),
            'external' => $this->returnPost('usuario_externo'),
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        if (!$this->formModel->returnFormId($postData['id'])) {
            $msg = 'O formulário informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $data = [
            'form_id' => $postData['id'],
            'external_user_id' => $postData['external'],
            'access_hash' => uniqid()
        ];

        $this->formModel->addExternalShare($data);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Compartilhado com sucesso.');
        return redirect()->to(base_url('formularios/compartilhar/' . $postData['id']));
    }

    public function deleteShareFormView()
    {
        $postData = [
            'id' => $this->returnPost('compartilha_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->route('formularios');
        }

        $acess = $this->formModel->getExternalById($postData['id']);

        if (empty($acess)) {
            $msg = 'O usuário informado não foi encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        return view('Forms/compartilhar-apagar', ['acesso' => $acess]);
    }

    public function deleteShare($api = false)
    {
        $postData = [
            'id' => $this->returnPost('compartilha_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        $acess = $this->formModel->getExternalById($postData['id']);

        if (empty($acess)) {
            $msg = 'O compartilhamento informado não foi encontrado.';

            if ($api) {
                return $this->returnErrorResponse($msg, 400);
            }

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        $this->formModel->removeShare($postData['id']);

        if ($api) {
            return $this->returnSuccessResponse($postData);
        }

        $this->setSuccessAlert('Compartilhamento removido com sucesso.');
        return redirect()->back();
    }

    public function answersView($formId)
    {
        $answers = $this->formModel->getResponsesByForm($formId);

        return $this->returnDefaultTemplate('Forms/respostas', ['respostas' => $answers, 'formulario' => $this->formModel->getFormById($formId)[0]], [base_url('assets/js/reviewResponses.js')]);
    }

    public function answersSummaryView($api = false)
    {
        $postData = [
            'id' => $this->returnPost('form_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        $questions = [];

        $formData = $this->formModel->returnResponses($postData['id']);

        foreach ($formData as $item) {
            if (!isset($questions[$item['question_id']])) {
                $questions[$item['question_id']] = [
                    'question_text' => $item['question_text'],
                    'options' => []
                ];
            }

            $questions[$item['question_id']]['options'][$item['option_id']] = [
                'option_text' => $item['option_text'],
                'option_count' => $item['response_count']
            ];
        }

        if ($api) {
            return $this->returnSuccessResponse($questions);
        }

        return view('Forms/resumo', ['resumo' => $questions]);
    }


    public function answersDetailedView()
    {
        $postData = [
            'id' => $this->returnPost('resposta_id')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        $questions = [];

        $formData = $this->formModel->returnDetailedResponse($postData['id']);

        foreach ($formData as $item) {
            if (!isset($questions[$item['question_id']])) {
                $questions[$item['question_id']] = [
                    'question_text' => $item['question_text'],
                    'options' => []
                ];
            }

            $questions[$item['question_id']]['options'][$item['option_id']] = [
                'option_text' => $item['option_text'],
                'answer_text' => $item['answer_text'],
                'option_count' => $item['checked'] == 'true' ? 1 : 0
            ];
        }

        return view('Forms/detalhe', ['detalhe' => $questions]);
    }

    public function answerExternalForm()
    {
        $postData = [
            'id' => $this->returnPost('form_id'),
            'username' => $this->returnPost('usuario')
        ];

        $emptyFields = 0;

        foreach ($postData as $data) {
            if (empty($data)) {
                $emptyFields++;
            }
        }

        if ($emptyFields > 0) {
            $msg = 'Preencha todos os campos obrigatórios.';

            $this->setDangerAlert($msg);
            return redirect()->back();
        }

        $hash = uniqid();
        $checkUserAccess = $this->formModel->getExternalByUsername($postData['id'], $postData['username']);
        $checkUser = $this->formModel->getExternalByUsername(false, $postData['username']);

        $formData = $this->formModel->getFormById($postData['id']);

        if (empty($formData)) {
            $msg = 'Formulário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        if ($formData[0]['form_share'] != '1') {
            $this->returnErrorResponse('Este formulário só permite acessos pré-autenticados.');
        }

        if ($checkUserAccess) {
            return $checkUserAccess['access_hash'];
        } else {
            if (!$checkUser) {
                $userId = $this->formModel->addExternalUser([
                    'username' => $postData['username']
                ]);
            } else {
                $userId = $checkUser['id'];
            }

            $this->formModel->addExternalShare([
                'form_id' => $postData['id'],
                'external_user_id' => $userId,
                'access_hash' => $hash
            ]);

            return $hash;
        }
    }


    public function answerAuthForm($shareHash)
    {
        $formData = $this->formModel->getFormByHash($shareHash);

        if (empty($formData)) {
            $msg = 'Formulário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        foreach ($formData as $row) {
            if ($row['posted'] != 1 || date('Y-m-d', strtotime($row['form_ends'])) < date('Y-m-d')) {
                $msg = 'Formulário inacessível.';

                $this->setDangerAlert($msg);
                return redirect()->route('login');
            }

            if (!isset($formArray['id'])) {
                $formArray['id'] = $row['form_id'];
                $formArray['name'] = $row['form_name'];
                $formArray['description'] = $row['form_description'];
                $formArray['posted'] = $row['posted'];
                $formArray['share'] = $row['form_share'];
                $formArray['answer_by'] = $row['access_hash'];
                $formArray['questions'] = [];
            }

            if ($row['question_id']) {
                if (!isset($formArray['questions'][$row['question_id']])) {
                    $formArray['questions'][$row['question_id']] = [
                        'id' => $row['question_id'],
                        'type' => $row['question_type'],
                        'text' => $row['question_text'],
                        'options' => []
                    ];
                }

                if ($row['option_text']) {
                    $formArray['questions'][$row['question_id']]['options'][] = [
                        'id' => $row['option_id'],
                        'text' => $row['option_text'],
                        'true' => $row['option_true']
                    ];
                }
            }
        }

        $usuarioExterno = $row['external_username'] . (empty($row['external_name']) ? ''  : ' (' . $row['external_name'] . ' ' . $row['external_surname'] . ')');

        $responses = $this->formModel->getResponsesByForm($formArray['id']);
        $userIds = array_column($responses, 'external_user_id');

        if (in_array($row['external_id'], $userIds)) {
            return $this->returnExternalTemplate('Answer/respondido');
        } else {
            return $this->returnExternalTemplate('Answer/responder', ['formulario' => $formArray, 'usuario' => $usuarioExterno], [base_url('assets/js/answers.js')]);
        }
    }

    public function answerForm($formId)
    {
        $formData = $this->formModel->getFormById($formId);

        if (!$this->userController->isLoggedIn()) {
            $this->setDangerAlert('Você não está identificado.');
            return redirect()->to('/login');
        }

        if (empty($formData)) {
            $msg = 'Formulário não encontrado.';

            $this->setDangerAlert($msg);
            return redirect()->route('login');
        }

        foreach ($formData as $row) {
            if ($row['posted'] != 1 || date('Y-m-d', strtotime($row['form_ends'])) < date('Y-m-d')) {
                $msg = 'Formulário inacessível.';

                $this->setDangerAlert($msg);
                return redirect()->route('login');
            }

            if (!isset($formArray['id'])) {
                $formArray['id'] = $row['form_id'];
                $formArray['name'] = $row['form_name'];
                $formArray['description'] = $row['form_description'];
                $formArray['posted'] = $row['posted'];
                $formArray['questions'] = [];
            }

            if ($row['question_id']) {
                if (!isset($formArray['questions'][$row['question_id']])) {
                    $formArray['questions'][$row['question_id']] = [
                        'id' => $row['question_id'],
                        'type' => $row['question_type'],
                        'text' => $row['question_text'],
                        'options' => []
                    ];
                }

                if ($row['option_text']) {
                    $formArray['questions'][$row['question_id']]['options'][] = [
                        'id' => $row['option_id'],
                        'text' => $row['option_text'],
                        'true' => $row['option_true']
                    ];
                }
            }
        }

        $formArray['answer_by'] = session()->get('usuario')['user_id'];

        $responses = $this->formModel->getResponsesByForm($formId);
        $userIds = array_column($responses, 'user_id');

        if (in_array($formArray['answer_by'], $userIds)) {
            $this->setDangerAlert('Você já respondeu esse formulário.');
            return redirect()->route('formularios');
        } else {
            return $this->returnExternalTemplate('Answer/responder', ['formulario' => $formArray, 'usuario' => session()->get('usuario')['username']], [base_url('assets/js/answers.js')]);
        }
    }

    public function saveResponses()
    {
        $postData = $this->request->getPost();
        $responses = [];

        $formId = $postData['form_id'];
        $user = $postData['user_id'];

        $dataResponse = [
            'form_id' => $formId,
            'response_date' => date('Y-m-d H:i:s')
        ];

        $externalUser = $this->formModel->getExternalByHash($user);

        if (!$externalUser) {
            $dataResponse['user_id'] = $user;
        } else {
            $dataResponse['external_user_id'] = $externalUser;
        }

        $responseId = $this->formModel->addResponse($dataResponse);

        foreach ($postData as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $parts = explode('_', str_replace('question_', '', $key), 2);
                $questionId = $parts[0];
                $type = isset($parts[1]) ? $parts[1] : '';

                $responses[$questionId] = [
                    'type' => $type,
                    'answers' => is_array($value) ? $value : [$value]
                ];
            }
        }

        foreach ($responses as $questionId => $data) {
            foreach ($data['answers'] as $answer) {
                $this->formModel->addResponseAnswer([
                    'response_id' => $responseId,
                    'question_id' => $questionId,
                    'option_id' => ($data['type'] == 'text' ? null : (is_numeric($answer) ? $answer : null)),
                    'answer_text' => ($data['type'] == 'text' ? $answer : (is_numeric($answer) ? null : $answer)),
                ]);
            }
        }
    }


    public function externalLogin($formId)
    {
        return $this->returnExternalTemplate('login-external', ['formulario' => $formId], [base_url('assets/js/external.js')]);
    }
}
