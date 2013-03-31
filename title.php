<?php

/* title.php
 *
 * Depending on a movie ID value passed to this page through a $_GET variable
 * the page will render based on that value. The movie ID defines what movie
 * information is output, and what reviews are retrieved from the database.
 *
 * Last Updated - 17/05/11
 * by Kieran Foxley-Jones
 */

session_start();

@include_once ('script/class.ListingScript.php');
@include_once ('script/class.sqlHandler.userdb.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Moovies</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/navMenu.css" />

    <link rel="stylesheet" type="text/css" href="css/reviewSubmit.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.ratings.css" />

    


    <script src="jscript/jquery-1.5.2.min.js" type="text/javascript"></script>
    <script src="jscript/reviewSubmit.js" type="text/javascript"></script>
    <script src="jscript/jquery.min.js" type="text/javascript"></script>
    <script src="jscript/navMenu.js" type="text/javascript"></script>
    <script src="jscript/posterResize.js" type="text/javascript"></script>
    
    <script type='text/javascript' src='jscript/jquery1.3.pack.js'></script>
    <script type="text/javascript" src="jscript/reviewVote.js"></script>

</head>
    <body>
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
                    <div id="contentFeaturePoster">
                        <?php
                            /* Retrives and outputs the movie Poster for the
                             * defined movie ID
                             */

                            $xml_movie_results = listingScript::getMovie($_GET['Mov_ID']);
                                $movieName = $xml_movie_results->movies->movie->name;

                            if (isset($xml_movie_results->movies->movie->images->image[2]['url'])) {
                                echo "<img width=\"185\" height=\"278\"class=\"Poster\" src=\"".$xml_movie_results->movies->movie->images->image[2]['url']."\"></img><br />";
                            }
                            else {
                                echo "<img src=\"images/no-poster.jpg\"></img><br />";
                            } ?>
                    </div>
                    <div id="contentFeatureReview">
                        <div id="contentMenuInfoWrap">
                            <?php
                            /* Outputs movie information based on te Movie ID
                             * into main content area, and information side bar */
                                @include_once ('script/reviewForm.php');?><br />
                             <?php echo "<a href=\"".(isset($xml_movie_results->movies->movie->trailer) ?
                                    $xml_movie_results->movies->movie->trailer."\">Trailer</a><br />" : "No Trailer<br />"); ?>
                            <br />
                            <?php
                                 setlocale(LC_MONETARY, 'en_US');

                                 echo "<h4>Info</h4>
                                        Rating: ".$xml_movie_results->movies->movie->certification."<br />
                                        Budget: $".number_format((int)$xml_movie_results->movies->movie->budget)."<br />
                                        Revenue: $".number_format((int)$xml_movie_results->movies->movie->revenue)."<br />
                                        Website: <a href=\"".(isset($xml_movie_results->movies->movie->homepage) ?
                                                $xml_movie_results->movies->movie->homepage."\">Link</a><br />" : "No Website<br />");   ?>
                        </div>
                        <h2><?php echo $xml_movie_results->movies->movie->name; ?> (<?php echo $xml_movie_results->movies->movie->released; ?>)</h2>
                        <h3><?php echo "Rating: ".$xml_movie_results->movies->movie->certification; ?></h3>
                        <p><?php echo $xml_movie_results->movies->movie->overview; ?></p>
                        <p> | <?php echo "<a href=\"".(isset($xml_movie_results->movies->movie->trailer) ?
                                    $xml_movie_results->movies->movie->trailer."\">Trailer</a>" : "No Trailer"); ?> | Average Review Rating | </p>
                    </div>
             </div>

                <div id="contentTop10Wrap">
                    <?php

                        /* Retrieves and outputs the revies stored within the
                         * database, uses Movie ID to output the correct ones
                         *
                         * Also outputs the voting system to each review
                         */
                        $query = "SELECT reviews.Rev_ID, Rev_Content, Rev_Date, Rev_Rating, Rev_Quality, Rev_Quote, users.username, Rev_Vote_Up, Rev_Vote_Down
                                FROM reviews, users, link
                                WHERE link.Rev_ID = reviews.Rev_ID
                                AND link.Mov_ID = ".$_GET['Mov_ID']."
                                AND link.User_ID = users.User_ID
                                ORDER BY reviews.Rev_Quality DESC;";

                        $movieRevData = sqlHandler::getDB()->select($query);

                        if (isset($movieRevData)) {

                            $numRows = count($movieRevData);
                            $i = 0;
                            while ($i < $numRows ) {

                                $effective_vote = $movieRevData[$i]['Rev_Vote_Up'] - $movieRevData[$i]['Rev_Vote_Down'];
                                echo "<div id=\"revIndivWrapper\">
                                        <div id=\"usrProfile\">
                                            <div id=\"usrPic\"><img src=\"images/profileimages/default.png\"></img></div>
                                                <strong>".$movieRevData[$i]['username']."</br></strong>Posted: ".$movieRevData[$i]['Rev_Date']."
                                            </div>
                                            <div id=\"revContent\">
                                                <h3>".$movieRevData[$i]['Rev_Quote']."</h3>
                                                <p>".preg_replace("/rn/", "<br/>", stripslashes($movieRevData[$i]['Rev_Content']))."
                                                </p>Rate this review :
                                                <span class\"vote_buttons\" id=\"vote_buttons".$movieRevData[$i]['Rev_ID']."\">
                                                <a href='javascript:;' class=\"vote_up\" id=\"".$movieRevData[$i]['Rev_ID']."\"> </a><br/>
                                                <a href='javascript:;' class=\"vote_down\" id=\"".$movieRevData[$i]['Rev_ID']."\"> </a></span>

                                                    <span class=\"votes_count\" id=\"votes_count".$movieRevData[$i]['Rev_ID']."\"\>".$effective_vote."</span>
                                            </div>
                                      </div>";
                                $i++;
                            }
                        }
                        else
                        {
                            echo "No Reviews";
                        }
                    ?>
                </div>               
            </div>

            <div id="footer">
                
            </div>
        </div>

    </body>
</html>