<?php
/*
 * 
 *
 */

session_start();

@include_once ('script/TMDb.php');
@include_once ('script/search.php');
@include_once ('script/class.sqlhandler.userdb.php');
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
				$password = $_SESSION['password'];
				$user_id = $_SESSION['user_id'];
				
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
                 <div id="leftcolumn">
                     
		 
		 </div>
		 <!-- End Left Column -->
		 
		 <!-- Begin Right Column -->
		 <div id="rightcolumn">
                 <?php




                    // If user has searched, else ouput standard list
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];
                        $xml_movie_results = tmdbSearch::Search($search);
                        $xml_movie_results = new SimpleXMLElement($xml_movie_results);

                        $i = 0;
                        while ($i < $xml_movie_results->movies->movie->count()) { //returns the amount of movie there are
                            echo "<a href=\"title.php?Mov_ID=".$xml_movie_results->movies->movie[$i]->id."\"
                                >".$xml_movie_results->movies->movie[$i]->name."</a><br />"; //outputs <name> in array position $i
                            echo "<img src=\"".$xml_movie_results->movies->movie[$i]->images->image[2]['url']."\"></img><br />";
                        $i++;

                        }
                    }
                    else
                    {
                        //get latest film from TMDb (latest added)
                            $tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
                            $xml_movie_results = $tmdb_xml->getLatestMovie();
                            $xml_movie_results = new SimpleXMLElement($xml_movie_results);
                            echo "<h2>Latest Movie</h2>";
                            echo "<a href=\"title.php?Mov_ID=".$xml_movie_results->movie->id."\"
                                >".$xml_movie_results->movie->name."</a><br />"; //outputs <name> in array position $i

                            if (isset($xml_movie_results->movies->movie[0]->images->image[2]['url'])) {
                                echo "<img src=\"".$xml_movie_results->movies->movie[0]->images->image[2]['url']."\"></img><br />";
                                }
                                else {
                                    echo "<img src=\"images/no-poster.jpg\"></img><br />";
                                }
                           

                        //get a top 10 list
                            $tmdb_xml = new TMDb('93a3f01925642df2c7898dc0d9fedcc7',TMDb::XML);
                            $genres = "12,28,16,35,80,105,18,82,14,36,9648,1115,878,53,37,10748,9805";  //
                            $xml_movie_results = $tmdb_xml->browseMovies('rating','desc', 'per_page=10&page=1&min_votes=25&genres='.$genres);
                            $xml_movie_results = new SimpleXMLElement($xml_movie_results);

                            $i = 0;
                            while ($i < $xml_movie_results->movies->movie->count()) { //returns the amount of movie there are
                                echo "<a href=\"title.php?Mov_ID=".$xml_movie_results->movies->movie[$i]->id."\"
                                >".$xml_movie_results->movies->movie[$i]->name."</a><br />"; //outputs <name> in array position $i

                                if (isset($xml_movie_results->movies->movie[$i]->images->image[2]['url'])) {
                                echo "<img src=\"".$xml_movie_results->movies->movie[$i]->images->image[2]['url']."\"></img><br />";
                                }
                                else {
                                    echo "<img src=\"images/no-poster.jpg\"></img><br />";
                                }
                            $i++;

                        }

                     }
                    
                 ?>

			Main Content
		 
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

