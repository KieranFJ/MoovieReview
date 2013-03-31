<?php
/* Review Rating
 *
 * Script that is run whenever a user votes for a review, stores the information
 * into the movies table of the database.
 *
 * taken and adapated from:
 * http://www.technabled.com/2009/02/reddit-style-voting-with-php-mysql-and.html
 *
 * Last Updated - 17/05/11
 * by Kieran Foxley-Jones
 */

@include_once ('class.sqlHandler.userdb.php');

function getAllVotes($id)  
 {  
 /** 
 Returns an array whose first element is votes_up and the second one is votes_down 
 **/  
    
 $query = "SELECT * FROM reviews WHERE Rev_ID = $id";
   
 $results = sqlHandler::getDB()->select($query);

 $votes = array();  
 if(isset($results))//id found in the table
  {    
  $votes[0] = $results[0]['Rev_Vote_Up'];
  $votes[1] = $results[0]['Rev_Vote_Down'];
  }  
 return $votes;  
 }

 function getEffectiveVotes($id)
 {
 /**
 Returns an integer
 **/
 $votes = getAllVotes($id);
 $effectiveVote = $votes[0] - $votes[1];
 return $effectiveVote;
 }


$id = $_POST['id'];
$action = $_POST['action'];

//get the current votes
$cur_votes = getAllVotes($id);

//ok, now update the votes

if($action=='vote_up') //voting up
{
 $votes_up = $cur_votes[0]+1;
 $query = "UPDATE reviews SET Rev_Vote_Up = $votes_up, Rev_Quality = ".(($cur_votes[0]-$cur_votes[1])+1)." WHERE Rev_ID = $id;";
}
elseif($action=='vote_down') //voting down
{
 $votes_down = $cur_votes[1]+1;
 $query = "UPDATE reviews SET Rev_Vote_Down = $votes_down, Rev_Quality = ".(($cur_votes[0]-$cur_votes[1])-1)." WHERE Rev_ID = $id;";
}

$r = sqlHandler::getDB()->update($query);
if($r) //voting done
 {
 $effectiveVote = getEffectiveVotes($id);
 echo $effectiveVote." votes";
 }
elseif(!$r) //voting failed
 {
 echo "Failed!";
 }

 ?>
<!--http://www.technabled.com/2009/02/reddit-style-voting-with-php-mysql-and.html-->