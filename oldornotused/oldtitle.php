<?php

/*  Title page, takes the movie id from the URL (Moiv_ID=#)
 *  uses SQL to get related information from the movie database
 *  then outputs it.
 *
 *  Also gets the relevant reviews from the review table using the
 *  link table for relationships.
 *
 *  13/3/11 - Things to do
 *
 *  Fix review output if no reviews exist - currently an error
 *  Stop anyone not logged in from submitting a review
 *  or allow anonymous comments (user_id 0) ?
 *
 *  Implement class.sqlhandler.userdb.php - done 13/3/11
 *  Format the movie info
 *  Format reviews
 *  Create review input form and INSERT query - seperate script/page? - 14/3/11
 *  Comment Code
 *  Reviews present validation
 *  
 * 
 *  Remove Commented code (old mysql connection stuff) *
 *
 */
session_start();

@Include 'script/class.sqlhandler.userdb.php';
@include 'script/TMDb.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Movie Review</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>

   <!-- Begin Wrapper -->
   <div id="wrapper">
   
         <!-- Begin Header -->
         <div id="header">
		 
		       This is the Header		 
			   
		 </div>
		 <!-- End Header -->
		 
		 <!-- Begin Navigation -->
         <div id="navigation">
			<?php 
			if (isset($_SESSION['username']))  //if true output already logged in, if false output non logged in
			{
				$username = $_SESSION['username'];
				//$password = $_SESSION['password'];
				//$user_id = $_SESSION['user_id'];
				
				echo "Hello $username, you are logged in.</br>";
			}
			else
			{
				?>
				<a href="Register.html">Register</a>
				<form action="script/login.php" enctype="multipart/form-data" method="post">
				<label for="Username">Username:</label><input type="text" id="username" name="username" />
				<label for="Password">Password:</label><input type="text" id="password" name="password" />
				<p class="submit"><input type="submit" value="Login" /></</p></form>;
			<?php
			}
			?>

		 <a href="script/logout.php">Logout</a>
		       This is the Navigation		 
			   
		 </div>
		 <!-- End Navigation -->
		 
		 <!-- Begin Left Column -->
                 <div id="contentWrapper">
		 <div id="leftcolumn">
                     <?php @include_once 'script/leftcolumn.php' ?>
			 
		 </div>
  
		 <!-- End Left Column -->
		 
		 <!-- Begin Right Column -->
		 <div id="rightcolumn">
			<?php  


//                        $movieId = $_GET['Mov_ID'];
//
//                        $tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
//                        $xml_movie_results = $tmdb_xml->getMovie($movieId);
//
//                        $xml_movie_results = new SimpleXMLElement($xml_movie_results);


			//$movieId = $_GET['Mov_ID'];
			//$query = "SELECT * FROM movies WHERE  Mov_ID = '$movieId';";
                        //$movieData = sqlHandler::getDB()->select($query);

			?>
                     <div id="movieinfowrapper">
                        <div id="movieinfooutput">
                            <!-- Movie Heading (Heading and release year)  -->
                            <h1><?php echo $xml_movie_results->movies->movie->name; ?> (<?php echo $xml_movie_results->movies->movie->released; ?>)</h1>

                            <br></br>
                            <?php echo $xml_movie_results->movies->movie->certification; ?>
                            <!-- Movie Description-->
                            <p><?php echo $xml_movie_results->movies->movie->overview; ?></p>
                           
                        

                        </div>
                         <div id="movieinfoposter">
                            <?php
                            if (isset($xml_movie_results->movies->movie->images->image[2]['url'])) {
                                echo "<img src=\"".$xml_movie_results->movies->movie->images->image[2]['url']."\"></img><br />";
                                }
                            else {
                                echo "<img src=\"images/no-poster.jpg\"></img><br />";
                            }
                                ?>
                         </div>
                     </div> <!-- end movie info wrapper -->
                    <div id="revWrapper">
                        <h2>User Reviews</h2>
			<?php 	
			// Review outputing script, reuses $query

                            $query = "SELECT Rev_Content, Rev_Date, Rev_Rating, Rev_Quality, Rev_Quote, users.username
                                    FROM reviews, users, link
                                    WHERE link.Rev_ID = reviews.Rev_ID
                                    AND link.Mov_ID = ".$movieId."
                                    AND link.User_ID = users.User_ID
                                    ORDER BY reviews.Rev_Quality DESC;";

                            $movieRevData = sqlHandler::getDB()->select($query);

                            if (isset($movieRevData)) {

                            //Output the reviews and any related info
                            //Needs formatting - 13/3/11

                            $numRows = count($movieRevData);
                            $i = 0;
                            while ($i < $numRows ) {
                                echo "<div id=\"revIndivWrapper\"><div id=\"usrPic\"><img src=\"images/profileimages/test.png\"></img>
                                    </div><div id=\"revContent\"><h3>".$movieRevData[$i]['Rev_Quote']."</h3>
                                      <p>".$movieRevData[$i]['Rev_Content']."</p>
                                          </div></div>";
                                //echo $movieRevData[$i]['Rev_Content']."<br>";

                                $i++;
                            }
                            }
                            else
                            {
                                echo "No Reviews";
                            }
			?>
                    </div>

                     <div id="revForm">
                    <form action="script/reviewup.php?Mov_ID=<?php echo $movieId;?>" enctype="multipart/form-data" method="post">
			
                            <h2>Write a review for <?php echo $xml_movie_results->movies->movie->name." (".$xml_movie_results->movies->movie->released.")";?></h2>
                            <label for="RevRating">Rating: </label>
                            <select id="RevRating" name="RevRating">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <p><label for="RevContent">Review: </label>
                            <textarea id="RevContent" name="RevContent" cols="60" rows="8">
Write your review here...
                            </textarea></p>

                            <input type="submit" value="Submit" />   <input type="submit" value="Cancel"/>
			
                    </form>
                     </div>
		 </div>
                 </div>
		 <!-- End Right Column -->
		 
		 <!-- Begin Footer -->
		 <div id="footer">
		       
			   This is the Footer		
			    
	     </div>
		 <!-- End Footer -->
		 
   </div>
   <!-- End Wrapper -->
   
</body>
</html> 