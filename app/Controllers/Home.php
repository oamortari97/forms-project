<?php

namespace App\Controllers;

use App\Models\FormModel;

class Home extends BaseController
{

    protected $formModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    public function index()
    {
        $forms = $this->formModel->getForms();
        $responses = count($this->formModel->getResponses('*'));

        $active = 0;
        $finished = 0;
        $answered = 0;

        $notificationData = [];

        foreach ($forms as $form) {
            if ($form['posted'] == 1) {

                if (date('Y-m-d', strtotime($form['ends'])) === date('Y-m-d')) {
                    $notificationData[] = [
                        'titulo' => 'O formulário finaliza hoje!',
                        'corpo' => 'O formulário ' . "'" . $form['name'] . "'" . ' começou em ' . formatDate($form['starts']) . ' e irá encerrar hoje!'
                    ];
                }

                if (date('Y-m-d', strtotime($form['ends'])) > date('Y-m-d')) {
                    $active++;
                } else {
                    $finished++;
                }
            } else {
                $notificationData[] = [
                    'titulo' => 'O formulário ainda está pendente!',
                    'corpo' => 'O formulário ' . "'" . $form['name'] . "'" . ' ainda não foi publicado!'
                ];
            }
        }

        $formData = [
            'ativos' => $active,
            'concluidos' => $finished,
            'respondidos' => $responses
        ];

        return $this->returnDefaultTemplate('dashboard', ['formularios' => $formData, 'notificacoes' => $notificationData]);
    }

    public function settings()
    {
        return $this->returnDefaultTemplate('Admin/Settings/ajustes');
    }
}
