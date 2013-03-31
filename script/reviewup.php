<?php

/* Review Upload Script
 *
 * Take user inputs and enters them into the database
 * First enters the review into the review table, returns a new review ID
 * Puts user id, movie id and review id into link table
 * Then puts querys the movie table to find if the movie id has been entered there
 * If not it puts the movie ID, name, review rating and amount of reviews into this table
 * If the ID does exist, it updates the review rating and the amount of reviews.
 *
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 *
 */

session_start();

@include_once 'class.sqlHandler.userdb.php';
sqlHandler::getDB();
// Read the form values
$success = false;
$revQuote = isset( $_POST['Summary'] ) ? mysql_real_escape_string($_POST['Summary'] ) : "";
$revRating = isset( $_POST['jsRating'] ) ? mysql_real_escape_string($_POST['jsRating'] ) : "";
$revContent = isset( $_POST['Review'] ) ? mysql_real_escape_string($_POST['Review'] ) : "";
$movieName = $_POST['Mov_Name'];

$userId = $_SESSION['User_id'];
$movieId = $_POST['Mov_ID'];
// If all values exist, send the email
if ( $revQuote && $revRating && $revContent ) {


    sqlHandler::getDB();
    //Enter content into review table
    $revContent = mysql_real_escape_string($revContent);

    $query = "INSERT INTO reviews
                (Rev_Content, Rev_Rating, Rev_Quote)
                VALUES ('$revContent','$revRating','$revQuote');";

  
    $revId = sqlHandler::getDB()->insert($query);

    //Enter ID's into Link table
    $query = "INSERT INTO link
                (Mov_ID, User_ID, Rev_ID)
                VALUES ('$movieId','$userId','$revId');";

    sqlHandler::getDB()->insert($query);
    
    //Selects any exiting movie ID's data from movies
    $query = "SELECT Mov_Review_Rating , Mov_Review_Amount
                FROM movies
                WHERE movies.Mov_ID = ".$movieId.";";
    $result = sqlHandler::getDB()->select($query);

    $movieRating = $result[0]['Mov_Review_Rating'] + $revRating;
    $movieRevAmount = $result[0]['Mov_Review_Amount'] + 1;

    //If no movie ID exits, result will be null, and thus all relevent data is entered
    //into the table, else existing data is updated with new values.
    if (isset($result)) {
        $query = "UPDATE movies
                    SET Mov_Review_Rating = ".$movieRating.", Mov_Review_Amount = ".$movieRevAmount."
                    WHERE Mov_ID = ".$movieId.";";
        sqlHandler::getDB()->update($query);
    }
    else {
        $query = "INSERT INTO movies
                    (Mov_ID, Mov_Name, Mov_Review_Rating, Mov_Review_Amount)
                    VALUES ('$movieId','$movieName','$movieRating','$movieRevAmount');";

        sqlHandler::getDB()->insert($query);
    }
    


    $success = "success";
}

// Return an appropriate response to the browser
if ( isset($_GET["ajax"]) ) {
  echo $success ? "success" : "error";
} else {
?>
<html>
  <head>
    <title>Thanks!</title>
  </head>
  <body>
  <?php if ( $success ) echo "<p>Thanks for sending your message! We'll get back to you shortly.</p>" ?>
  <?php if ( !$success ) echo "<p>There was a problem sending your message. Please try again.</p>" ?>
  <p>Click your browser's Back button to return to the page.</p>
  </body>
</html>
<?php
}
?>