<?php
/* Login Menu Script
 * Simple script to output a login form on all pages if a user is not logged in
 * If they are logged in a small message, and link to logout is displayed instead
 *
 * Last Updated - 17/05/11
 * by Kieran Foxley-Jones
 */

if (isset($_SESSION['User_id']) && isset($_SESSION['Username'])) {
    echo "you are logged in ".$_SESSION['Username']."<br />";
    echo "<img src=\"images/profileimages/default.png\"></img>";
    //echo "<a href=\"profile.php\">Edit Profile</a><br />";
    echo "<a href=\"script/logout.php\">Logout</a>";
}
else {
    echo "<form action=\"script/login.php\" enctype=\"multipart/form-data\" method=\"post\">
        <strong><label for=\"Username\">Username:</label></strong><input type=\"text\" id=\"Username\" class=\"input\" name=\"Username\" /><br />
        <strong><label for=\"Password\">Password:</label></strong><input type=\"password\" id=\"Password\" class=\"input\" name=\"Password\" /><br />
        <div id=\"buttons\"><input type=\"image\" src=\"css/Images/LoginButton.gif\" /></form>
        <form action=\"signup.php\" enctype=\"multipart/form-data\" method=\"post\"><input type=\"image\" src=\"css/Images/SignupButton.gif\"/> </form></div>
    ";
}

?>