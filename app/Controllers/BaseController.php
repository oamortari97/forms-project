<?php

namespace App\Controllers;

use Config\Services;
use CodeIgniter\Controller;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\SessionInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected $apiController;
    protected $userController;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Inicializa o ApiController
        $this->apiController = new ApiController;
        $this->userController = new UserController;
    }

    /**
     * Método para retorno de resposta JSON padronizado
     *
     * @param mixed   $data     Dados a serem retornados
     * @param integer $code     Código de status HTTP
     * @param string  $type     Tipo da resposta ('success' ou 'error')
     * @return void
     */
    public function returnResponse($data, $code = 200, $type = 'success'): void
    {
        header('Content-Type: application/json; charset=utf-8');

        http_response_code($code);

        $response = [
            'date' => date('Y-m-d H:i'),
            'success' => ($type === 'success'),
            'http' => [
                'status' => $code,
                'description' => returnHttpDescription($code),
            ],
            'return' => [
                'data' => $data
            ],
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit(0);
    }

    /**
     * Método para retorno de resposta de sucesso
     *
     * @param mixed   $data     Dados a serem retornados
     * @param integer $code     Código de status HTTP (padrão 200)
     * @return void
     */
    public function returnSuccessResponse($data, $code = 200): void
    {
        $this->returnResponse($data, $code, 'success');
    }

    /**
     * Método para retorno de resposta de erro
     *
     * @param mixed   $data     Dados a serem retornados
     * @param integer $code     Código de status HTTP (padrão 500)
     * @return void
     */
    public function returnErrorResponse($data, $code = 500): void
    {
        $this->returnResponse($data, $code, 'error');
    }

    /**
     * Obtém a instância atual da requisição
     *
     * @return RequestInterface
     */
    public function request(): RequestInterface
    {
        return Services::request();
    }

    /**
     * Obtém a instância atual de sessões
     *
     * @return SessionInterface
     */
    public function session(): SessionInterface
    {
        return Services::session();
    }


    /**
     * Retorna uma mensagem tipo alerta para a view
     *
     * @param string $type  Tipo da mensagem a ser exibida
     * @param string $message   Conteúdo da mensagem a ser exibida
     */
    public function setAlert($type, $message)
    {
        $icon = '';
        $class = '';

        switch ($type) {
            case 'success':
                $icon = 'check';
                $class = 'success';
                break;
            case 'warning':
                $icon = 'exclamation';
                $class = 'warning';
                break;
            case 'danger':
                $icon = 'close';
                $class = 'danger';
                break;
        }

        $alert['alerta'] = "<div class=\"main-alert\" id=\"alert-display\">
            <div class=\"alert-icon alert-" . $class . "\">
                <span class=\"material-symbols-outlined\">
                    " . $icon . "
                </span>
            </div>
            <div class=\alert-msg\">
                " . $message . "
            </div>
            <div class=\"alert-close\" id=\"close-alert\">
                <span class=\"material-symbols-outlined\">
                    close
                </span>
            </div>
        </div>";

        return $this->session()->set($alert);
    }

    /**
     * Retorna uma mensagem de sucesso tipo alerta para a view
     *
     * @param string $message   Conteúdo da mensagem a ser exibida
     */
    public function setSuccessAlert($message)
    {
        return $this->setAlert('success', $message);
    }


    /**
     * Retorna uma mensagem de alerta tipo alerta para a view
     *
     * @param string $message   Conteúdo da mensagem a ser exibida
     */
    public function setWarningAlert($message)
    {
        return $this->setAlert('warning', $message);
    }


    /**
     * Retorna uma mensagem de erro tipo alerta para a view
     *
     * @param string $message   Conteúdo da mensagem a ser exibida
     */
    public function setDangerAlert($message)
    {
        return $this->setAlert('danger', $message);
    }

    /**
     * Retorna um conteúdo recebido via post
     *
     * @param mixed $key   Chave do post a ser retornada
     */
    public function returnPost($key)
    {
        // TODO: Adicionar validações do post
        return $this->request()->getPost($key);
    }

    /**
     * Retorna um conteúdo recebido via post
     *
     */
    public function returnPostArr()
    {
        return $this->request()->getPost();
    }

   /**
     * Retorna um conteúdo recebido via post
     *
     * @param mixed $key   Chave do post a ser retornada
     */
    public function returnGet($key)
    {
        // TODO: Adicionar validações do get
        return $this->request()->getGet($key);
    }

    /**
     * Retorna um conteúdo de login
     *
     */
    public function returnTemplateLogin()
    {
        return view('login');
    }

    /**
     * Retorna o template padrão 
     *
     * @param string $view  Caminho/nome da view a ser exibida
     * @param array $data  Dados da view
     * @param array $scripts Scripts adicionais a serem incluídos
     */
    public function returnDefaultTemplate($view, $data = [], $scripts = [])
    {
        $viewContent = view($view, $data);

        $templateData = [
            'view' => $viewContent,
            'scripts' => $scripts
        ];

        return view('Templates/default.php', $templateData);
    }

      /**
     * Retorna o template externo 
     *
     * @param string $view  Caminho/nome da view a ser exibida
     * @param array $data  Dados da view
     * @param array $scripts Scripts adicionais a serem incluídos
     */
    public function returnExternalTemplate($view, $data = [], $scripts = [])
    {
        $viewContent = view($view, $data);

        $templateData = [
            'view' => $viewContent,
            'scripts' => $scripts
        ];

        return view('Templates/external.php', $templateData);
    }
}
