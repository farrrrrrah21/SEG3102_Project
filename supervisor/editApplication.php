<?php
session_start();
if ($_SESSION['loggedIn'] == false) {
	header("Location: ../index.php?action=login");
}
if ($_SESSION['userType'] != 'Supervisor') {
	include "../403.php";
	die();
}

$updated = false;
$dbconn = mysqli_connect("localhost","root","", "d3");
$LoginID = $_SESSION['loginId'] ;

//get applications
$getAllQuery = "select applicationNumber, presentationDetail from applicationrequest where supervisor = '".$LoginID."'";
$allApplications = mysqli_query($dbconn, $getAllQuery) or die ("Applications were not found ".mysqli_error($dbconn));
$applications = mysqli_fetch_all($allApplications);

if (!empty($_POST['status'])) {
	$statusUpdateQuery = "update applicationrequest set applicationStatus = '".$_POST['status']."' where applicationNumber = '".$_GET['app']."'";
	$result = mysqli_query($dbconn, $statusUpdateQuery) or die ("Application update failed. ".mysqli_error($dbconn));
	
	$loginresult = mysqli_query($dbconn, "select LoginId, presentationDetail from applicationrequest where applicationNumber='".$_GET['app']."'") or die ("Cannot retrieve application ".mysqli_error($dbconn));
	$loginIdData = mysqli_fetch_array($loginresult);	
	$applicantID = $loginIdData['LoginId'];
	$superName = $_SESSION['fullName'];
	$mess = "";
	$pTitle = $loginIdData['presentationDetail'];
	if ($_POST['status'] == "Incomplete") {
		$mess = stripcslashes($_POST['comments']);
		$mess = mysqli_real_escape_string($dbconn, $mess);
	}
	if ($_POST['status'] == "Refused") {
		$mess = "Your application $pTitle has been refused.";
	}
	if ($_POST['status'] == "Pending Faculty Evaluation") {
		$mess = "Your application $pTitle has been approved and is now pending falculty evaluation.";
	}
	$sendMessage = "insert into inboxitems (LoginId, sender, message) values ('$applicantID', '$superName', '$mess')";
	$result = mysqli_query($dbconn, $sendMessage) or die ("Notification Failed to Send. ".mysqli_error($dbconn));
	$updated = "Application successfully updated";
}

$status = "";
$conferenceDetails = "";
$presentationType = "";
$registration = "";
$transportation = "";
$accomendation = "";
$meals = "";
$advanced = "";
$student = "";
$title = "";

$result = mysqli_query($dbconn, "select * from applicationrequest where applicationNumber='".$_GET['app']."'") or die ("Cannot retrieve application ".mysqli_error($dbconn));
$appData = mysqli_fetch_array($result);
if ($appData != null) {
	if ($appData['presentationDetail'] != null) {
		$title = $appData['presentationDetail'];
	}
	if ($appData['conferenceDetails'] != null) {
		$conferenceDetails = $appData['conferenceDetails'];
	}
	if ($appData['typeOfPresentation'] != null) {
		$presentationType = $appData['typeOfPresentation'];
	}
	if ($appData['registrationExpense'] != null) {
		$registration = $appData['registrationExpense'];
	}
	if ($appData['transportationExpense'] != null) {
		$transportation = $appData['transportationExpense'];
	}
	if ($appData['accomendationExpense'] != null) {
		$accomendation = $appData['accomendationExpense'];
	}
	if ($appData['mealsExpense'] != null) {
		$meals = $appData['mealsExpense'];
	}
	if ($appData['advancedFunds'] != null) {
		$advanced = $appData['advancedFunds'];
	}
	if ($appData['applicationStatus'] != null) {
		$status = $appData['applicationStatus'];
	}
	if ($appData['LoginId'] != null) {
		$login = $appData['LoginId'];
		$result = mysqli_query($dbconn, "select first_name, last_name from users where LoginId='$login'") or die ("Cannot retrieve application ".mysqli_error($dbconn));
		$userData = mysqli_fetch_array($result);
		$student = $userData['first_name']." ".$userData['last_name'];
	}
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
                <a class="navbar-brand" href = "supervisor.php">Supervisor</a>
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
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class=""></i> Application list <i class="fa fa-fw fa-caret-down"></i></a>
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
                            <?php echo $title; ?>
                        </h1>
						<?php
							if ($updated != false) {
								echo "<h4 style='color:green;'>$updated</h4>";
							}
						?>
                        <ol class="breadcrumb">
                            
                            <li class="active">
                                <i></i> Status: <?php echo $status; ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               <script>
					function yesComments() {
						document.getElementById('comment').required = true;
						document.getElementById('comment').style.display = "block";
					}
							
					function noComments() {
						document.getElementById('comment').required = false;
						document.getElementById('comment').style.display = "none";
					}
				</script>
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12">
						Applicant Name: <input type="text" placeholder="Applicant Name" name = "applicant" value = "<?php echo $student; ?>" readonly>
                        Conference Details: <br><br><textarea name="conferenceDetails" rows="5" cols="40" readonly><?php echo $conferenceDetails; ?></textarea><br><br>
                        Type of Presentation: <input type="text" placeholder="Enter Type of Presentation" name = "PresentationType" value = "<?php echo $presentationType; ?>" readonly>
                        
                        Registration Expense ($): <input type="double" name = "registration" value = "<?php echo $registration; ?>" readonly>
                        Transportation Expense ($): <input type="double" name = "transportation" value = "<?php echo $transportation; ?>" readonly>    
                        Accommodation Expense ($): <input type="double" name = "accomendation" value = "<?php echo $accomendation; ?>" readonly>
						Meals Expense ($): <input type="double" name = "meals" value = "<?php echo $meals; ?>" readonly>
                        Advanced Funds (optional) ($): <input type="double" name = "advanced" value = "<?php echo $advanced; ?>" readonly>
						
						<?php
							if ($status == "Pending Supervisor Approval") {
								echo "<form action='editApplication.php?app=".$_GET['app']."' method = 'POST' >";
								echo "<input type='radio' name='status' value='Pending Faculty Evaluation' onclick='noComments()' checked>";
								echo "Approve<br><br>";
								echo "<input type='radio' name='status' value='Refused' onclick='noComments()'>";
								echo "Refuse<br><br>";
								echo "<input type='radio' name='status' value='Incomplete' onclick='yesComments()'> ";
								echo "Request Changes<br><br>";
								echo "<textarea placeholder = 'Comments:' name='comments' rows='5' cols='40' id='comment' 
									style = 'outline: none; padding: 10px; display: none; width: 300px; border-radius: 3px; 
									border: 1px solid #eee; margin: 20px auto;'></textarea>";
								echo "<br><br><input type='submit'></form>";
							}
						?>	
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
