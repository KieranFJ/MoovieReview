<?php

/* 
 *
 */

session_start();
//If someone who isn't logged in, send them back to index
if (!isset($_SESSION['User_id']) && !isset($_SESSION['Username'])) {
    header('Location: index.php');
}

@include_once ('script/class.ListingScript.php');
@include_once ('script/class.profile.php');

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
        <script src="jscript/jquery-1.5.2.min.js" type="text/javascript"></script>
        <script src="jscript/showForm.js" type="text/javascript"></script>
        <script src="jscript/navMenu.js" type="text/javascript"></script>
        <script type="text/javascript">


$(document).ready(function() {
  $('div.UserReviews:eq(0)> div').hide();
  $('div.UserReviews:eq(0)> h3').click(function() {
    $(this).next().slideToggle('fast');
  });
});

/*$(document).ready(function() {
 // hides the slickbox as soon as the DOM is ready
  $('.slickbox').hide();
 // shows the slickbox on clicking the noted link
  $('#slick-show').click(function() {
    $('#slickbox').show('slow');
    return false;
  });
 // hides the slickbox on clicking the noted link
  $('#slick-hide').click(function() {
    $('#slickbox').hide('fast');
    return false;
  });

 // toggles the slickbox on clicking the noted link
  $('#slick-toggle').click(function() {
    $('.slickbox').toggle(400);
    return false;
  });
});*/

    </script>



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
                    <div id="profileForm">

                        <?php 
                        $profileData = profile::profileUserInfo();
                        
                        $max_file_size = 30000;
                        
                        ?>
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"/>
                        <h2>Your Profile</h2>
                        <form action="script/register.php" enctype="multipart/form-data" method="post">
                            
                        <strong>Enter your present password to edit your details:</strong><br />
                        <label for="CurrPassword">CurrPass :</label><input type="password" id="CurrPassword" class="input" name="CurrPassword"/><br />
                        <label for="Email">Email :</label><input type="text" id="Email" class="input" name="Email" value="<?php echo $profileData[0]['User_Email']; ?>"/><br />

                        <label for="FirstName">First Name :</label><input type="text" id="FirstName" class="input" name="FirstName" value="<?php echo $profileData[0]['User_FirstName']; ?>" /><br />
                        <label for="Surname">Surname :</label><input type="text" id="Surname" class="input" name="FirstName" value="<?php echo $profileData[0]['User_Surname'];?>" /><br />
                        <label for="Password">Change Password :</label><input type="password" id="NewPassword" class="input" name="NewPassword"/><br />
                        <!-- Profile Pic upload here -->
                        <label for="ProfilePicture">Profile :</label><img src="images/profileimages/<?php echo $profileData[0]['User_ProfilePicture']; ?>"></img><br />
                        <label for="New Picture">New Picture :</label><input id="NewPicture" type="file" name="NewPicture" />
                        <p class="Submit"><input type="submit" value="Submit" /></p>
			
				</form>

                    </div>
                    <div class="UserReviews"> <?php profile::profileReviewList() ?></div>
             </div>


            </div>

            <div id="footer">

            </div>
        </div>

    </body>
</html>