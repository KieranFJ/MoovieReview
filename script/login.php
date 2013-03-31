<?php
/*  Movie Review
 *  Login Script
 *  Simple script that takes $_POST from any page which displays the login form
 *  (all of them if not logged in) uses class.sqlhandler.userb.php to handle
 *  SQL queries. Also uses hashes to check the password
 *
 *   hash of password
 *      add salt (from database)
 *          hash saltpassword
 *
 *  Result should be the same as the stored hash if the password is correct.
 *
 *  10/3/11 - To Do
 *  Implement class.sqlhandler.userdb.php - done 11/3/11
 *  Remove old commented code - done 13/3/11
 *  Comment code
 * 
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 *
 */

@include("class.sqlHandler.userdb.php");

$username = $_POST['Username'];
$password = $_POST['Password'];

$query = "SELECT *
        FROM users
        WHERE username = '$username';";

$userData = sqlHandler::getDB()->select($query);

//Checks the hash of the password entered against the one stored within the 
//database, it takes the password, hashes it, adds the salt from the database
//then hashes the total
$hash = hash('sha256', $userData[0]['salt'] . hash('sha256', $password) );

if($hash != $userData[0]['password']) //incorrect password
{
    header('Location: ../signup.php');
}
else
{		
	session_start();
	
	$_SESSION['User_id'] = $userData[0]['User_ID'];
	$_SESSION['Username'] = $username;
	//$_SESSION['password'] = $userData[0]['password'];

	header('Location: ../index.php');
}
?>