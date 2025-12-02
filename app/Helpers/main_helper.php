<?php

/**
 * Função para retorno de descrição do código HTTP
 *
 * @param string  $httpCode
 */
function returnHttpDescription($httpCode)
{
    $statusCodes = [
        '100' => 'Continue',
        '101' => 'Switching Protocols',
        '200' => 'OK',
        '201' => 'Created',
        '202' => 'Accepted',
        '204' => 'No Content',
        '301' => 'Moved Permanently',
        '302' => 'Found (Moved Temporarily)',
        '304' => 'Not Modified',
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '500' => 'Internal Server Error',
        '501' => 'Not Implemented',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '418' => "I'm a teapot",
    ];

    if (array_key_exists($httpCode, $statusCodes)) {
        return $statusCodes[$httpCode];
    } else {
        return 'Unknown Status';
    }
}

/**
 * Função para retorno de string criptografada
 *
 * @param string  $text
 * @param string  $passphrase
 */
function encrypt($text, $passphrase)
{
    if (empty($text) || empty($passphrase)) return $text;

    $salt = openssl_random_pseudo_bytes(8);
    $salted = "";
    $dx = "";
    while (strlen($salted) < 48) {
        $dx = md5($dx . $passphrase . $salt, true);
        $salted .= $dx;
    }

    return base64_encode('Salted__' . $salt . openssl_encrypt($text . '', 'aes-256-cbc', substr($salted, 0, 32), OPENSSL_RAW_DATA, substr($salted, 32, 16)));
}

/**
 * Função para retorno de string descriptografada
 *
 * @param string  $encrypted
 * @param string  $passphrase
 */
function decrypt($encrypted, $passphrase)
{
    if (empty($encrypted) || empty($passphrase)) return $encrypted;

    $encrypted = base64_decode($encrypted);
    if (substr($encrypted, 0, 8) !== "Salted__") return null;

    $salt = substr($encrypted, 8, 8);
    $encrypted = substr($encrypted, 16);
    $salted = "";
    $dx = "";
    while (strlen($salted) < 48) {
        $dx = md5($dx . $passphrase . $salt, true);
        $salted .= $dx;
    }

    return openssl_decrypt($encrypted, 'aes-256-cbc', substr($salted, 0, 32), true, substr($salted, 32, 16));
}

/**
 * Verifica se a string representa um valor booleano verdadeiro ou falso
 * e retorna um ícone visual correspondente.
 *
 * @param string $value A string que deve ser verificada.
 * @return string O HTML para o ícone visual (check verde ou cruz vermelha).
 */
function getBooleanIcon($value)
{
    $normalizedValue = strtolower(trim($value));

    $true = '<i class="bi bi-check-lg text-success"></i>';
    $false = '<i class="bi bi-x-lg text-danger"></i>';

    if ($normalizedValue === 'true' || $normalizedValue === '1' || $normalizedValue === 'yes' || $normalizedValue === 'on') {
        return $true;
    } else {
        return $false;
    }
}

/**
 * Converte uma data em qualquer formato para o padrão d/m/Y e opcionalmente inclui hora.
 *
 * @param string $date A data em qualquer formato.
 * @param string $format Opcional. Define a formatação da hora. Pode ser 'H', 'H:i', 'H:i:s', ou uma string vazia para apenas d/m/Y.
 * @return string A data formatada no padrão d/m/Y e hora opcional.
 * @throws Exception Se a data fornecida não puder ser parseada.
 */
function formatDate($date, $format = '')
{
    try {
        $dateTime = new DateTime($date);

        $baseFormat = 'd/m/Y';

        switch ($format) {
            case 'H':
                $baseFormat .= ' H';
                break;
            case 'H:i':
                $baseFormat .= ' H:i';
                break;
            case 'H:i:s':
                $baseFormat .= ' H:i:s';
                break;
            default:
                break;
        }

        return $dateTime->format($baseFormat);
    } catch (Exception $e) {
        return 'Data inválida';
    }
}

/**
 * Gera o HTML para uma mensagem de confirmação de exclusão.
 *
 * @param string $username O nome do usuário ou item a ser excluído.
 * @return string O HTML para a mensagem de confirmação.
 */
function generateDeletionConfirmationHtml($type, $name)
{
    $escapedUsername = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    return '
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="text-danger" style="font-size:2.5rem">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
        <div role="alert" aria-live="assertive" class="text-center">
            Você tem certeza que deseja excluir o ' . $type . ' <strong>' . $escapedUsername . '</strong>? <br>
            Este processo é definitivo e não poderá ser desfeito.
        </div>
    </div>';
}

function returnMainRoute($str = null)
{
    $rota = uri_string();

    if ($str) {
        $rota = str_replace($str, '', $rota);
        return str_replace('/', '', $rota);
    }

    if (isset(explode('/', $rota)[0])) {
        return explode('/', $rota)[0];
    } else {
        return $rota;
    }
}
