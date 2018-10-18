<?php

$nome = filter_input(INPUT_POST, 'nome');


include '../vendor/autoload.php';

use WEBUtils\Secure\TokenForm;

$t = new TokenForm();
$token = $_COOKIE['acesso-site'];
$page = 'form1';

if ($t->isTokenValido($token, $page)) {
    echo "nome: " . $nome;
} else {
    echo $t->getMensagem();
}