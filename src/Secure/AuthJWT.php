<?php

namespace WEBUtils\Secure;

use WEBUtils\Secure\JWT;

class AuthJWT {

    private $key;
    private $header;
    private $JWT;

    public function __construct() {
        $this->JWT = new JWT();
        $this->key = "mac789789&";
        $this->header = '{"typ":"JWT","alg":"HS256"}';
    }

    public function geraToken($username, $email) {
        //???

        $payload = array(
            "exp" => date('Y-m-d', strtotime("+1 days")),
            "name" => $username,
            "email" => $email
        );
        $token = $this->JWT->encode($this->header, json_encode($payload), $this->key);
        return $token;
    }

    public function authToken($token) {
        $mensagem = 'Token valido';
        $isTokenValido = false;
        //getallheaders()['Authorization']; o token esta aqui <.<
        if (!$token) {
            $mensagem = "Token nao informado";
        } else {

            $json = $this->JWT->decode($token, $this->key);
            if (!$json) {
                $mensagem = "Token Invalido";
            } else {
                $json = json_decode($json);
                $dataToken = $json->{'exp'};
                if (strtotime($dataToken) === strtotime(date('Y-m-d'))) {
                    $mensagem = "Token Expirado";
                } else {
                    $isTokenValido = true;
                }
            }
        }

        $response = array(
            "isValido" => $isTokenValido,
            "mensagem" => $mensagem
        );
        //echo json_encode($response);
        return $response;
    }

}
