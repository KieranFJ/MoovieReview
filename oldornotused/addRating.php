<?php
define('api_key', '93a3f01925642df2c7898dc0d9fedcc7');

@include_once 'TMDb.php';

$getToken = new TMDb(api_key ,TMDb::JSON);
$token = $getToken->getToken();

echo $token."<br />";

$session = $getToken->getSession($token);

echo $session


?>
