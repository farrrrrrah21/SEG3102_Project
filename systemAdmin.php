<?php
session_start();

if ($_SESSION['loggedIn'] == false) {
	header("Location: index.php?action=login");
}
if ($_SESSION['userType'] != 'System Admin') {
	include "403.php";
	die();
}

$dbconn =mysqli_connect("localhost","root","", "d3");
$result = mysqli_query($dbconn, "select LoginId, first_name, last_name from users where status='Supervisor'") or die ("Supervisers were not found ".mysqli_error($dbconn));;
$exists = false;
$supervisors = mysqli_fetch_all($result);

if( !empty($_POST['loginID']) && !empty($_POST['password']) 
&& !empty($_POST['first_name']) && !empty($_POST['last_name'])
&& !empty($_POST['e-mail']) && !empty($_POST['status'] ) ){ 
//Get values:
    $loginID = $_POST['loginID'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email = $_POST['e-mail'];
    $status = $_POST['status'];

// to prevent mysqli injection
    $loginID = stripcslashes($loginID);
    $password = stripcslashes($password);
    $first_name = stripcslashes($first_name);
    $last_name = stripcslashes($last_name);
    $email = stripcslashes($email);
    $status = stripcslashes( $status);

    $loginID = mysqli_real_escape_string($dbconn, $loginID);
    $password = mysqli_real_escape_string($dbconn, $password);
    $first_name = mysqli_real_escape_string($dbconn, $first_name);
    $last_name = mysqli_real_escape_string($dbconn, $last_name);
    $email = mysqli_real_escape_string($dbconn, $email);
    $status = mysqli_real_escape_string($dbconn, $status);

//connect to the server and select database 
    //$dbconn =mysqli_connect("localhost","root","", "d3");
    //mysql_select_db("d3");
	
    $result = mysqli_query($dbconn, "INSERT INTO users (LoginId, password,last_name, first_name, email, status)
    VALUES('$loginID','$password','$last_name','$first_name','$email','$status')") or die ("failed to query database ".mysqli_error($dbconn));
    
	if ($status == "Requester") {
		$superviser = $_POST['supervisorList'];
		$profile = mysqli_query($dbconn, "INSERT INTO requester (LoginId, supervisor) 
		VALUES('$loginID', '$superviser')") or die ("failed to query database ".mysqli_error($dbconn));
	}
	
	if ($result == true) {
		$exists = true;
	}
	
	/*$row = mysqli_fetch_array($result);

    if($row['LoginId']== $loginID && $row['password']== $password ){ 
        $exits = true; 

    } */ 
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CGTS-Homepage</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">System Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               
           
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['f_name'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?action=logout"><i class=""></i> Sign Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                            
                    </li>
                      <li class="active">
                        <a href=""><i class=""></i> Add User </a>
                    </li>
                    
                   
                    <li>
                     
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <br>
                        <h1 class="page-header">
                            Add User
                        </h1>
						<?php if($exists == true) {echo "<h4 style='color:green;'>User Successfully Added.</h4>";}?>
                        <ol class="breadcrumb">
                            
                            <li class="active">
                                <i class=""></i> Add User
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12">
                        


                        <h2 class="page-header">Enter the Following Information: </h2>

                      <font size="3" color="black">Status: </font>

                        <head>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" /><br><br>
                    </head>
						<script>
							function requesterSelected() {
								document.getElementById('supervisors').style.display = 'block';
								document.getElementById('supervisors').required = true;
							}
							
							function requesterDeselected() {
								document.getElementById('supervisors').style.display = 'none';
								document.getElementById('supervisors').required = false;
							}
						</script>

                        <form action="systemAdmin.php" method = "POST" > 
                    
                             <input type="radio" name="status" value="System Admin" onclick="requesterDeselected()" checked> 
                        System Admin<br><br>
                        <input type="radio" name="status" value="Requester" onclick="requesterSelected()"> 
                        Requester<br><br>
                         <input type="radio" name="status" value="Financial Office Staff" onclick="requesterDeselected()"> 
                        Financial Office Staff<br><br>
                         <input type="radio" name="status" value="Supervisor" onclick="requesterDeselected()"> 
                        Supervisor<br><br>
                        <input type="text" placeholder="Enter First Name" name = "first_name" required>
                        <input type="text" placeholder="Enter last Name" name = "last_name" required>
                        <input type="text" placeholder="Enter e-mail" name = "e-mail" required>
                        <input type="text" placeholder="Enter user login ID" name = "loginID" required>
                        <input type="password" placeholder="Enter user password" name = "password" required>
						<?php
							$style = "style='outline: none; padding: 10px; display: none; width: 300px; border-radius: 3px; border: 1px solid #eee; margin: 20px auto;'";
							if ($supervisors != null) {
								$select = "<select ".$style." id='supervisors' name='supervisorList'><option value=''>Select a Supervisor</option>";
								foreach ($supervisors as $supervisor) {
									$select = $select."<option value = '".$supervisor[0]."'>".$supervisor[1]." ".$supervisor[2]."</option>";
								}
								$select = $select."</select>";
								echo $select;
							}
						?>
                        <input type="submit" > 
                        </form>


                    </div>
                </div>
                <!-- /.row -->


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>



    

</body>

</html>
