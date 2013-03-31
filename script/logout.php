<?php

/* logout.php
 *
 * When a user clicks on a logout link, this script is run, killing any
 * session variables and cookies releated to the user. Returns them to index.php
 *
 * Last Updated - 17/05/11
 * by Kieran Foxley-Jones
 */

session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header('Location: ../index.php');
?>