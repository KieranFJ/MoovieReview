<?php

/* Index.php
 *
 * Main index page of the website, uses multiple scripts to output data to the
 * page.
 *
 * Functions in use from script/class.ListingScript.php include:
 * listingScript::top10Genre() lists the genres from TMDB.org into the nav bar
 * listingScript::top5Movies() Top five rated movies
 * listingScript::latestReview() Latest five reviews Review
 * listingScript::top10list() Ouputs the top 10 from TMDB.org
 *
 * script/recentReview.php - outputs the latest review
 *
 *  Last updated 17/05/11
 *  by Kieran Foxley-Jones
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
        <script type='text/javascript' src='jscript/jquery1.3.pack.js'></script>

        <script src="jscript/navMenu.js" type="text/javascript"></script>
        <script src="jscript/posterResize.js" type="text/javascript"></script>

        <!-- REMOVE THIS -->

        <div style="width:200px; float:left; position:absolute; left: 0px; top: 0px; z-index: -1;"><h2>To do list!</h2>
                        <h3>All old accounts are gone, make a new one to post a review- sorry</h3>
            <p>To Do: <br />
            More/better menus<br />
            User profile controls<br />
            admin interface<br />
            moderator interface?<br />
            more left column content<br />
            use tmdb.org api to add ratings from here to theirs<br />
            truncate outputs (descriptions, reviews) and elegantly increase size when needed<br />
            general formatting work (review form, new menus etc)<br />
            review ratings - <strong>needs work to stop multiple voting</strong><br />
            <br /><br />
            Fixed/Added:<br />
            <strong>review ratings</strong><br />
            <strong>Better formatting for reviews - lack of paragraphing<br/></strong>
            Images with no links<br />
            review form buttons not working<br />
            fix up poster outputs<br />
            movie ratings - visual 10 star rating implemented, needs some formatting work though<br />
            <strong>Left column content (5 recent reviews, top 5 reviews)<br />
            Newest Review in main content area</strong>

            </p></div>
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
            <?php listingScript::latestReview(); ?>

                <div id="contentTop10Wrap">
                    <?php listingScript::top10list(); ?>
                </div>
            </div>

            <div id="footer">
                
            </div>
        </div>

    </body>
</html>