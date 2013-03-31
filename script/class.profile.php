<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
@include_once ('script/class.sqlHandler.userdb.php');

class profile {

    public static function profileUserInfo() {
        
        $userID = $_SESSION['User_id'];
        $username = $_SESSION['Username'];

        $query = "SELECT User_Email , User_FirstName , User_Surname , User_Location, User_ProfilePicture
                        FROM profile
                        WHERE profile.User_ID = \"$userID\" ;";

        $profileData = sqlHandler::getDB()->select($query);

        return $profileData;
    }

    public static function profileReviewList() {
        $query = "SELECT link.Rev_ID, Rev_Content, Rev_Quote, Rev_Date, link.Mov_ID, movies.Mov_Name
                    FROM link, reviews, movies
                    WHERE link.User_ID = ".$_SESSION['User_id']."
                    AND link.Rev_ID = reviews.Rev_ID
                    AND link.Mov_ID = movies.Mov_ID;";

        $reviewList = sqlHandler::getDB()->select($query);

        $i = 0;
        while ($i < count($reviewList)) {
           echo "
                <h3>".$reviewList[$i]['Mov_Name']."  ".$reviewList[$i]['Rev_Date']."   ".$reviewList[$i]['Rev_Quote']."</h3>
                <div class=\"formInvid\">
                <form id=\"ProfileReviewForm\" action=\"script/profileReviewUp\" method=\"post\" >
                    <input type=\"hidden\" name=\"Rev_ID\" value=\"".$reviewList[$i]['Rev_ID']."\" />
                        <label for=\"ReviewSummary\"><strong>Summary</strong></label><br />
                    <textarea name=\"ReviewSummary\" cols=30 rows=1>".$reviewList[$i]['Rev_Quote']."</textarea>
                    <textarea name=\"ReviewContent\" cols=92 rows=20>".preg_replace("/rn/", "<br/>", stripslashes($reviewList[$i]['Rev_Content']))."</textarea><br />
                    <input type=\"submit\" id=\"editReview\" name=\"editReview\" value=\"Edit Review\" />
                    <input type=\"button\" id=\"deleteReview\" name=\"deleteReview\" value=\"Delete Review\" />


                </form><br /></div>";


              /* echo "
                <a href=\"#\" id=\"slick-toggle\">".$reviewList[$i]['Mov_Name']."  ".$reviewList[$i]['Rev_Date']."</a>        
                <div class=\"slickbox\"> 
                <form id=\"ProfileReviewForm\" action=\"script/profileReviewUp\" method=\"post\" >
                    <input type=\"hidden\" name=\"Rev_ID\" value=\"".$reviewList[$i]['Rev_ID']."\" />
                    <textarea name=\"Review".$reviewList[$i]['Rev_ID']."\" cols=40 rows=10>".preg_replace("/rn/", "<br/>", stripslashes($reviewList[$i]['Rev_Content']))."</textarea><br />
                    <input type=\"submit\" id=\"editReview\" name=\"editReview\" value=\"Edit Review\" />
                    <input type=\"button\" id=\"deleteReview\" name=\"deleteReview\" value=\"Delete Review\" />


                </form><br /></div>";*/

          $i++;
        }
    }

}
?>