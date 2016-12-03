<?php
session_start();
$message = false;
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'logout') {
		$_SESSION['loggedIn'] = false;
	}
	if ($_GET['action'] == 'login') {
		$message = "You are not logged in.";
	}
}
$loginError = false;
// Press submit, provides password loginID and Password 

if(!empty($_POST['loginID']) && !empty($_POST['password']) ){
	//connect to the server and select database 
	$dbconn =mysqli_connect("localhost","root","", "d3");
	
	//Get values:
	$username = $_POST['loginID'];
	$password = $_POST['password'];

	// to prevent mysql injection
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysqli_real_escape_string($dbconn, $username);
	$password = mysqli_real_escape_string($dbconn, $password);

	$result = mysqli_query($dbconn, "select * from users where LoginId='$username'
		and password='$password'") or die ("failed to query database ".mysqli_error($dbconn));

	$row = mysqli_fetch_array($result);

	if($row['LoginId']== $username && $row['password']== $password ){
		//echo "Login success!!! Welcome " .$row['userID'];

		//$row = pg_fetch_row($result);
			////////$firstName = $row[0];
		$f_name = $row['first_name'];
		$loginId = $row['LoginId'];
		/////////$_SESSION['firstName']  = $firstName;
		
		//parameters we want to pass:
		$_SESSION['f_name'] = $f_name ;
		$_SESSION['loginId']= $loginId ;
		$_SESSION['loggedIn'] = true;
		$_SESSION['fullName'] = $f_name." ".$row['last_name'];
		$_SESSION['userType'] = $row['status'];
		//////$_SESSION['email'] = $email;
		
		//header("Location: homepage.php");

		//if status is System Admin 
		if($row['LoginId']== $username && $row['password']== $password && $row['status']=="System Admin"){
		header("Location: systemAdmin.php");
		}

		//if status is requester 
		if($row['LoginId']== $username && $row['password']== $password && $row['status']=="Requester"){
		header("Location: requester/requester.php");
		}
		
		//if status is Financial Office Staff 
		if($row['LoginId']== $username && $row['password']== $password && $row['status']=="Financial Office Staff"){
		header("Location: financialOfficeStaff.php");
		}


		// if status is Supervisor
		if($row['LoginId']== $username && $row['password']== $password && $row['status']=="Supervisor"){
		header("Location: supervisor/supervisor.php");
		}

	} else {
		$loginError = "Login ID or password is incorrect.";
	}
}

if( empty($_POST['loginID']) && !empty($_POST['password']) ) {
	$loginError = "Please enter your login ID.";

}

if( !empty($_POST['loginID']) && empty($_POST['password']) ) {
	$loginError = "Please enter your password.";
}

/*
// Press submit and provide no login iD and provide  password  
if (isset($_POST['submit']) && empty($_POST['loginID']) && !empty($_POST['password'])) {
	echo "<font color='white' size=5>Please provide userID.</font>";
}

// Press submit and provide  login iD and no provide  password  
if (isset($_POST['submit']) && !empty($_POST['loginID']) && empty($_POST['password'])) {
	echo "<font color='white' size=5>Please provide password.</font>";
} else {

	echo "<font color='white' size=5>Please provide loginID and password.</font>";
}
*/
//}
	?>

<!DOCTYPE html> 
<html>
	<head> 
		<title> Login </title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" />
	</head> 
	<body background="students.jpg" > 
		<div style = 'background:rgba(255,255,255, 0.3); height:100vh;'>
		<div class="header">
			<a >Conference Travel Grant System (CTGS) </a>
		</div>
		<?php
			if ($message != false) {
				echo "<br><br><div style = 'color:DarkRed; background:rgba(255,255,255, 0.3); padding-top:0.25px; padding-bottom:0.25px;'>";
				echo "<h3>";
				echo $message;
				echo "</h3></div>";
			}
			
			if ($loginError != false) {
				echo "<br><br><div style = 'color:DarkRed; background:rgba(255,255,255, 0.3); padding-top:0.25px; padding-bottom:0.25px;'>";
				echo "<h3>";
				echo $loginError;
				echo "</h3></div>";
			}
		?>
		<h1> Login </h1>
			<form action="index.php" method = "POST" > 
			
			<input type="text" placeholder="Enter your login ID" name = "loginID">
			<input type="password" placeholder="Enter your password" name = "password">
			<input type="submit" > 
		</div>
	</body>	
</html>