<?php
/*
 * Script to query the database for the latest five posted reviews. This is then
 * output to the left column area on the index.php page allowing people to move
 * to the listed movies.
 * 
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 */

@include_once ('script/class.sqlHandler.userdb.php');
@include_once ('script/class.ListingScript.php');

$query = "SELECT Mov_ID
            FROM link
            ORDER BY Mov_ID DESC
            LIMIT 5;";

$results = sqlHandler::getDB()->select($query);



$i = 0;

while ($i < count($results)) {
    
    $getMovieName = listingScript::getMovie($results[$i]['Mov_ID']);
    
    $results[$i]['Mov_Name'] = $getMovieName->movies->movie->name;
    echo "<a href=\"title.php?Mov_ID=".$results[$i]['Mov_ID']."\">".$results[$i]['Mov_Name']."</a><br />";
    $i++;
}

?>
