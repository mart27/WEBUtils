<?php
include '../vendor/autoload.php';
use WEBUtils\Secure\TokenForm;

$t = new TokenForm();

$token = $t->geraToken('form');
//setcookie('acesso-site', $token, time() + (86400 * 30), "/");

//$url = 'http://localhost/WEBUtils/teste/take_form.php';
//
//$context = stream_context_create(array(
//    'http' => array(
//        'method' => 'POST',
//        'header' => 'Content-type: application/x-www-form-urlencoded',
//        'content' => http_build_query(
//            array(
//                'token' => $token,
//                'nome' => '47xxxxxxxx'                
//            )
//        ),
//        'timeout' => 60
//    )
//));
//
//$resp = file_get_contents($url, FALSE, $context);
//print_r($resp);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="take_form.php" name="form">            
            <input type="hidden" name="token" id="token" value="<?php echo $token;?>" />
            <input type="text" name="nome" /> <input type="submit" name="bt" value="enviar" />
        </form>
    </body>
</html>
