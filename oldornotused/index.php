
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Fixed Width CSS Layouts - 2 Column - fw-16-2-col</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>

<?php
session_start();

?>

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
				Username:<input type="text" id="username" name="username"/>
				Password:<input type="text" id="password" name="password"/>
				<p class="submit"><input type="submit" value="Login" /></p></form>
			<?php
			}
			?>

		 <a href="script/logout.php">Logout</a>
		       This is the Navigation		 
			   
		 </div>
		 <!-- End Navigation -->
		 
		 <!-- Begin Left Column -->
		 <div id="leftcolumn">
			<a href="movies.php">Movie List</a>
		       Left Column
		 
		 </div>
		 <!-- End Left Column -->
		 
		 <!-- Begin Right Column -->
		 <div id="rightcolumn">
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