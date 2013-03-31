<?php
/* MovieReview
 * Review Upload script
 *
 */

session_start();

$userId = $_SESSION['user_id'];
$movieId = $_GET['Mov_ID'];
$revContent= $_POST['RevContent'];
$revRating = $_POST['RevRating'];

@include 'class.sqlHandler.userdb.php';

sqlHandler::getDB();

$revContent = mysql_real_escape_string($revContent);

$query = "INSERT INTO reviews
            (Rev_Content, Rev_Rating)
            VALUES ('$revContent','$revRating');";

$revId = sqlHandler::getDB()->insert($query);

$query = "INSERT INTO link
            (Mov_ID, User_ID, Rev_ID)
            VALUES ('$movieId','$userId','$revId');";

sqlHandler::getDB()->insert($query);


header("Location: ../title.php?Mov_ID=$movieId");

?>