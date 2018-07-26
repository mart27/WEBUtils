<?php
include '../vendor/autoload.php';

use WEBUtils\Secure\TokenForm;

$t = new TokenForm();

echo $t->geraToken();
