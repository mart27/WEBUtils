<?php
include '../vendor/autoload.php';

use WEBUtils\Secure\TokenForm;

$token = filter_input(INPUT_POST, 'token');
$page = 'form';
$t = new TokenForm();

if ($t->isTokenValido($token, $page)) {
$nome = filter_input(INPUT_POST, 'nome');
    echo "nome: " . $nome;
} else {
    echo $t->getMensagem();
}