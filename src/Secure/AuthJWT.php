<?php

namespace WEBUtils\securit;

use WEBUtils\secure\JWT;

class AuthJWT {

    private $key;
    private $header;
    private $JWT;
    private $nome;
    private $id;
    private $email;

    public function __construct() {
        $this->JWT = new JWT();
        $this->key = "key3@Rt5&tg$3&";
        $this->header = '{"typ":"JWT","alg":"HS256"}';
    }

    public function geraToken($id, $username, $email = '', $chave = '') {
        //???
        $context = array(
            "id" => $id,
            "name" => $username,
            "email" => $email,
            "chave" => $chave,
        );

        $payload = array(
            "iss"=> "www.mactus.com.br",
            "iat" => date('Y-m-d H:i:s'),
            "exp" => date('Y-m-d H:i:s', strtotime("+1 days")),
            "sub" => $id,
            "context" => $context
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
                    $this->id = $json->{'id'};
                    $this->nome = $json->{'name'};
                    $this->email = $json->{'email'};
                    $isTokenValido = true;
                }
            }
        }

        $response = array(
            "isValido" => $isTokenValido,
            "mensagem" => $mensagem,
            "json" => $json
        );
        //echo json_encode($response);
        return $response;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

}
