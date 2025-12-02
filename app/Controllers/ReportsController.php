<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\FormModel;

class ReportsController extends BaseController
{

    protected $formModel;

    public function __construct()
    {
        $this->formModel = new FormModel();
    }

    public function reports()
    {
        $forms = $this->formModel->getForms();
        $finishedForms = [];

        foreach ($forms as $form) {
            if (date('Y-m-d', strtotime($form['ends'])) < date('Y-m-d')) {
                $finishedForms[] = $form;
            }
        }

        return $this->returnDefaultTemplate('Admin/Reports/relatorios', ['formularios' => $finishedForms]);
    }

    public function reportDetail($formId)
    {

        $questions = [];

        $formData = $this->formModel->returnResponses($formId);

        $formInfo = [
            'name' => $formData[0]['form_name'],
            'description' => $formData[0]['description'],
            'starts' => $formData[0]['starts'],
            'ends' => $formData[0]['ends'],
            'author' => $formData[0]['name'] . " " . $formData[0]['surname'],
        ];

        foreach ($formData as $item) {
            if (!isset($questions[$item['question_id']])) {
                $questions[$item['question_id']] = [
                    'question_text' => $item['question_text'],
                    'options' => []
                ];
            }

            $questions[$item['question_id']]['options'][$item['option_id']] = [
                'option_text' => $item['option_text'],
                'option_true' => $item['option_true'],
                'option_count' => $item['response_count']
            ];
        }
        // Instância do dompdf
        $dompdf = new Dompdf();

        // Carrega a view com o conteúdo HTML
        $html = view('Admin/Reports/pdf', ['formInfo' => $formInfo, 'formulario' => $questions]); // Nome da view que contém o HTML acima

        // Configurações do dompdf
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf->setOptions($options);

        // Carrega o conteúdo HTML
        $dompdf->loadHtml($html);

        // Define o tamanho do papel e a orientação
        $dompdf->setPaper('A4', 'portrait');

        // Renderiza o PDF
        $dompdf->render();

        // Envia o PDF gerado ao navegador para download
        $dompdf->stream($formInfo['name'] . '.pdf', ["Attachment" => true]);
        // $dompdf->stream("arquivo.pdf", ["Attachment" => 0]);
    }

    public function reportPdf($formId)
    {
        $this->reportDetail($formId);
    }
}
