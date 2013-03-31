<?php

/* Movies Page
 *
 * This page is used to to output user defined data, such as the results of a
 * users search, or listing of a user selected genre. Content changes depending
 * on these inputs.
 *
 * Last Updated - 17/05/11
 * by Kieran Foxley-Jones
 *
 *  */


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
        <script src="jscript/posterResize.js" type="text/javascript"></script>
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
                    <?php 

                    if (isset ($_POST['search'])) {
                        listingScript::searchList($_POST['search']);                        
                    }
                    elseif (isset ($_GET['Genre_ID'])){
                        listingScript::browseGenreList($_GET['Genre_ID']);
                        }

                        //else if genre list

                            //else if alpha list
                    //else if top10list
                    else {
                        listingScript::top10list();
                    }



                    ?>
                </div>
            </div>

            <div id="footer">
                
            </div>
        </div>

    </body>
</html>