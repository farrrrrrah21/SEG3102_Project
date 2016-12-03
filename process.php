<?php
/*
//

if(!empty($_POST['email']) && !empty($_POST['password'])){
//Get values:
	$username = $_POST['email'];
	$password = $_POST['password'];

// to prevent mysql injection
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);

//connect to the server and select database 
	$dbconn =mysql_connect("localhost","root","");
	mysql_select_db("d3");

	$result = mysql_query("select * from users where userID='$username'
		and password='$password'") or die ("failed to query database ".mysql_error());
	$row = mysql_fetch_array($result);
	if($row['userID']== $username && $row['password']== $password ){
		echo "Login success!!! Welcome " .$row['userID'];
	} else {

		session_start();
$_SESSION['message'] = 'success';
//header("Location: $location");
		header("Location: login.php");
	//	echo "<font color='black' size=5> Failed to login.</font>";

	}
}

//}
*/
echo "success";
	?>