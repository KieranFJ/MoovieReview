<?php

/* Signup.php
 * Simple signup page that sends the user submitted information to
 * scripts/registration.php. Creates a user login within the database
 * and send the user back to the main index page.
 *
 * Last updated 17/05/11
 * by Kieran Foxley-Jones
 */


session_start();

@include_once ('script/class.ListingScript.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Moovies</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/navMenu.css" />
</head>

    <body>
        <script src="jscript/jquery.min.js" type="text/javascript"></script>
        <script src="jscript/navMenu.js" type="text/javascript"></script>
        <div id="wrapper">

            <div id="header">
                <a href="index.php"><img src="images/Banner.png" alt="Moovies - Movie Review Website"></img></a>
                <div id="loginBox">
                    <?php @include_Once ('script/loginMenu.php'); ?>
                </div>
            </div>

            <div id="navigation">
                <div id="navBar">
                    <ul id="jsddm">
                        <li><span>By Genre</span>
                            <ul>
                                <?php listingScript::top10Genre(); ?>
                            </ul>
                        </li>
                        <li>By Letter
                            <ul>
                                <li>Alphabetical list here</li>
                            </ul>
                        </li>
                    </ul>

                </div>
                <div id="navSearch">
                    <form action="movies.php" enctype="multipart/form-data" method="post">
                        <strong>Search: </strong><input type="text" id="search" class="search" name="search" />
                        <input type="Submit" value="Go" />
                    </form>
                </div>
            </div>

            <div id="leftcolumnWrapper">
                <div class="leftColumnMenuTitle">
                        <strong>
                            <span>Recently Reviewed</span>
                        </strong>
                </div>
                    <div class="leftColumnMenuContent">
                        <strong><?php @include_once('script/recentReview.php'); ?></strong>
                    </div>

                <div class="leftColumnMenuTitle">
                        <strong>
                            <span>Top 5 Movies</span>
                        </strong>
                </div>
                    <div class="leftColumnMenuContent">
                        <strong><?php  listingScript::top5Movies();  ?></strong>
                    </div>

                <div class="leftColumnMenuTitle">
                        <strong>
                            <span>Categories</span>
                        </strong>
                </div>
                    <div class="leftColumnMenuContent">
                        Action<br />
                        Adventure<br />
                        Drama<br />
                        Thriller<br />
                    </div>

            </div>



            <div id="contentWrapper">
                <div id="contentFeatureWrap">
                    <div id="contentTop10Wrap">
                        
                        <script type="text/javascript">
                            function validateSignup() {
                                var email=document.forms["signupForm"]["Email"].value
                                if (email==null || email=="")   {
                                    //document.getElementById('emaiAlert').innerHTML = 'Email must be filled out';
                                    alert("Email must be filled out");
                                    return false;
                                }
                            }
                            
                    
                        </script>
                        
                    <form name="signupForm" action="script/register.php" enctype="multipart/form-data" method="post" onsubmit="return validateSignup()" >
			


                                <label for="E-Mail">E-Mail :</label><input type ="text" id="Email" class="input" name="Email" /> <b id="emailAlert"></b><br />
				<label for="Username">Username :</label><input type="text" id="Username" class="input" required="required" name="Username"/><br />
				<label for="Password">Password :</label><input type="password" id="Password" class="input" name="Password"/><br />

                                <p class="Submit"><input type="submit" value="Submit" /></p>
			
				</form>
                    </div>
             </div>


            </div>

            <div id="footer">

            </div>
        </div>

    </body>
</html>