<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include '../vendor/autoload.php';
use WEBUtils\Secure\TokenForm;

$t = new TokenForm();

$token = $t->geraToken('form');
setcookie('acesso-site', $token, time() + (86400 * 30), "/");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="take_form.php" name="form">
            <input type="text" name="nome" /> <input type="submit" name="bt" value="enviar" />
        </form>
    </body>
</html>
