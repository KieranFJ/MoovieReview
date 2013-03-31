<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

@include_once("class.sqlHandler.userdb.php");
session_start();

class loginReg {

    function process() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $this->login();
        }
        else {

        }

    }
    

    public function login($username, $password) {
        $query = "SELECT *
                FROM users
                WHERE username ='$username';";

        $userData = sqlHandler::getDB()->select($query);

        $hash = hash('sha256', $userData[0]['salt'].hash('sha256', $password));
        if ($hash != $userData[0]['password']) {
            header ('Location: ../register.html');
        }
        else {
            session_start();
            $_SESSION['user_id'] = $userData[0]['User_ID'];
            $_SESSION['username'] = $username;
            header('Location: ../index.php');
        }
    }

    public function logout() {
        session_start();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        }



session_destroy();

header('Location: ../index.php');
    }

    public function registration($username, $password) {
        $hash = hash('sha256', $password);
        $salt = createSalt();

        $hash = hash('sha256', $salt.$hash);

        $query = "INSERT INTO users ( username, password, salt )
        VALUES ( \"$username\" , \"$hash\" , \"$salt\" );";

        sqlHandler::getDB()->insert($query);

        header('Location: ../index.php');
    }

    function createSalt() {
        $string = md5(uniqid(rand(), true));
        return substr($string, 0, 3);
    }
}
?>
