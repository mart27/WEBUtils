<?php

namespace WEBUtils\Secure;

/**
 * Description of TokenForm
 *
 * @author Marcelo
 */
class TokenForm {

    private $key = 'Cg45rf@$F%%$32SD68+9@';
    private $header;
    private $JWT;
    private $mensagem;

    public function __construct() {
        $this->JWT = new JWT();
        $this->header = '{"typ":"JWT","alg":"HS256"}';
    }

    public function geraToken($page) {
        $payload = array(
            "exp" => date('Y-m-d H:i:s', strtotime("+10 minute")),
            "page" => $page
        );
        $token = $this->JWT->encode($this->header, json_encode($payload), $this->key);
        return $token;
    }

    public function isTokenValido($token, $page) {

        $this->mensagem = 'Token valido';
        $isTokenValido = false;
        //getallheaders()['Authorization']; o token esta aqui <.<
        if (!$token) {
            $this->mensagem = "Token nao informado";
        } else if (!$page) {
            $this->mensagem = "Pagina de acesso nao informada";
        } else {
            $json = $this->JWT->decode($token, $this->key);
            if (!$json) {
                $this->mensagem = "Token Invalido";
            } else {
                $json = json_decode($json);
                $dataToken = $json->{'exp'};
                if (strtotime($dataToken) === strtotime(date('Y-m-d'))) {
                    $this->mensagem = "Token Expirado";
                } else if ($page != $json->{'page'}) {
                    $this->mensagem = "Pagina de acesso incorreta";
                } else {
                    $isTokenValido = true;
                }
            }
        }

        return $isTokenValido;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

}
