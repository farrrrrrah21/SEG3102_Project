<?php
session_start();

if ($_SESSION['loggedIn'] == false) {
	header("Location: ../index.php?action=login");
}
if ($_SESSION['userType'] != 'Requester') {
	include "../403.php";
	die();
}

$dbconn = mysqli_connect("localhost","root","", "d3");
$LoginID = $_SESSION['loginId'] ;

//get applications
$getAllQuery = "select applicationNumber, presentationDetail from applicationrequest where LoginId = '".$LoginID."'";
$allApplications = mysqli_query($dbconn, $getAllQuery) or die ("Applications were not found ".mysqli_error($dbconn));
$applications = mysqli_fetch_all($allApplications);

$result = mysqli_query($dbconn, "select * from Requester where LoginId='$LoginID'") or die ("Please update requester profile first ".mysqli_error($dbconn));

$row = mysqli_fetch_array($result);

$message = false;

if($row['LoginId'] == $LoginID && $row['studentNumber'] == null){ 
    $message = "You have not created your profile, in order to submit an application you need a completed profile.";
} else {
	$supervisor = $row['supervisor'];
}

$appMsg = false;
if (!empty($_POST['conferenceDetails'])) {
	$conDetails = stripcslashes($_POST['conferenceDetails']);
	$presentationType = stripcslashes($_POST['PresentationType']);
	$presentationTitle = stripcslashes($_POST['PresentationTitle']);
	
	$conDetails = mysqli_real_escape_string($dbconn, $conDetails);
	$presentationType = mysqli_real_escape_string($dbconn, $presentationType);
	$presentationTitle = mysqli_real_escape_string($dbconn, $presentationTitle);
	
	$addApplicationQuery = "insert into applicationrequest 
		(LoginId, conferenceDetails, typeOfPresentation, presentationDetail, registrationExpense, 
		transportationExpense, accomendationExpense, mealsExpense, advancedFunds, applicationStatus, supervisor) 
		values("
		."'".$LoginID."', "
		."'".$conDetails."', "
		."'".$presentationType."', "
		."'".$presentationTitle."', "
		."'".$_POST['registration']."', "
		."'".$_POST['transportation']."', "
		."'".$_POST['accomendation']."', "
		."'".$_POST['meals']."'";
	
	if (!empty($_POST['advanced'])) {
		$addApplicationQuery = $addApplicationQuery.", '".$_POST['advanced']."', 'Pending Supervisor Approval', '$supervisor')";
	} else {
		$addApplicationQuery = $addApplicationQuery.", '', 'Pending Supervisor Approval', '$supervisor')";
	}

	$result = mysqli_query($dbconn, $addApplicationQuery) or die ("Application was not submitted ".mysqli_error($dbconn));
	$appMsg = "Application Submitted Successfully";
}

// If advanced(optional) is given: 
/*if( !empty($_POST['conferenceDetails']) && !empty($_POST['PrentationType']) 
&& !empty($_POST['PresentationTitle']) && !empty($_POST['registration'])
&& !empty($_POST['transportation']) && !empty($_POST['advanced'] ) ){ 

    //Get values:
    $conferenceDetails = $_POST['conferenceDetails'];
    $PrentationType = $_POST['PrentationType'];
    $PresentationTitle = $_POST['PresentationTitle'];
    $registration  = $_POST['registration'];
    $transportation = $_POST['transportation'];
    $advanced = $_POST['advanced'];


// to prevent mysql injection
    $loginID = stripcslashes($loginID);
    $password = stripcslashes($password);
    $first_name = stripcslashes($first_name);
    $last_name = stripcslashes($last_name);
    $email = stripcslashes($email);
    $status = stripcslashes( $status);

    $loginID = mysql_real_escape_string($loginID);
    $password = mysql_real_escape_string($password);
    $first_name = mysql_real_escape_string($first_name);
    $last_name = mysql_real_escape_string($last_name);
    $email = mysql_real_escape_string($email);
    $status = mysql_real_escape_string($status);
}*/

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
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
         <head>
                    <link rel="stylesheet" type="text/css" href="../style.css">
                    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" /><br><br>

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
                <a class="navbar-brand" href = "requester.php">Requester</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               
           
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['f_name'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="inbox.php"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                       
                        <li class="divider"></li>
                        <li>
                           <a href="../index.php?action=logout"><i class=""></i> Sign Out</a>  
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="requester.php"><i class=""></i> Create Application </a>
                    </li>
                    
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class=""></i> My application list <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
							<?php
								if ($applications != null) {
									foreach ($applications as $app) {
										echo "<li><a href='editApplication.php?app=".$app[0]."'>".$app[1]."</a></li>";
									}
								}
							?>
                        </ul>
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
                        <h1 class="page-header">
                            Create Application
                        </h1>
						<h4 style = "color:red;">
						<?php if ($message != false) {echo $message;} ?>
						</h4>
						<h4 style = "color:green;">
						<?php if ($appMsg != false) {echo $appMsg;} ?>
						</h4>
                        <ol class="breadcrumb">
                            
                            <li class="active">
                                <i class=""></i> Create Application
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12">
                        


                    


                         <form action="requester.php" method = "POST" > 
                    
                        <textarea placeholder = "Conference Details (1000 characters):" name="conferenceDetails" rows="5" cols="40" required></textarea>
                        <input type="text" placeholder="Enter Type of Presentation" name = "PresentationType" required>
                        <input type="text" placeholder="Enter Presentation Title" name = "PresentationTitle" required>
                        
                        <input type="double" placeholder="Enter Registration Expense ($)" name = "registration" required>
                        <input type="double" placeholder="Enter Transportation Expense ($)" name = "transportation" required>    
                        <input type="double" placeholder="Enter Accommodation Expense ($)" name = "accomendation" required>
						<input type="double" placeholder="Enter Meals Expense ($)" name = "meals" required>
                        <input type="double" placeholder="Enter Advanced Funds (optional) ($)" name = "advanced">
                      
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
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>


    

</body>

</html>
