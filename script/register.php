<?php
/* Movie Review -                                               Date 13/3/11
 * Created by Kieran Foxley-Jones
 * Register Script
 *
 * Simple script which takes user inputs and inserts it into the user table of
 * userdb
 * creates a hash from input password, adds a generated salt, and then hashes
 * the saltpassword combo. This is stored as the password within the database
 * 
 * Uses class.sqlHandler.userdb.php to handle SQL
 *
 * To Do
 * Comment Code
 * Implement sqlHandler - done 13/3/11
 * Remove old code - done 13/3/11
 * 
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 * 
 */

@include("class.sqlHandler.userdb.php");

$username = $_POST['Username'];
$password = $_POST['Password'];
$email = $_POST['Email'];
$defaultImage = "default.png";

$hash = hash('sha256', $password);

function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}

$salt = createSalt();
$hash = hash('sha256', $salt . $hash);

$query = "INSERT INTO users ( username, password, salt )
        VALUES ( \"$username\" , \"$hash\" , \"$salt\" );";

$userID = sqlHandler::getDB()->insert($query);



$query = "INSERT INTO profile ( USER_ID, User_Email, User_ProfilePicture )
        VALUES ( \"$userID\" , \"$email\" , \"$defaultImage\") ;";

sqlHandler::getDB()->insert($query);

header('Location: ../index.php');

?>