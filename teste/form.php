<?php
include '../vendor/autoload.php';
use WEBUtils\Secure\TokenForm;

$t = new TokenForm();

echo $token = $t->geraToken('form');
//setcookie('acesso-site', $token, time() + (86400 * 30), "/");
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
