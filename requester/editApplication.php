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

$status = "";
$conferenceDetails = "";
$presentationType = "";
$registration = "";
$transportation = "";
$accomendation = "";
$meals = "";
$advanced = "";
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
                           <a href="index.php?action=logout"><i class=""></i> Sign Out</a>  
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="requester.php"><i class=""></i> Create Application </a>
                    </li>
                    
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class=""></i> My application list <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="">
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
                            <?php echo $title; ?>
                        </h1>
						
                        <ol class="breadcrumb">
                            
                            <li class="active">
                                <i></i> Status: <?php echo $status; ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12">
                        Conference Details: <br><br><textarea name="conferenceDetails" rows="5" cols="40" readonly><?php echo $conferenceDetails; ?></textarea><br><br>
                        Type of Presentation: <input type="text" placeholder="Enter Type of Presentation" name = "PresentationType" value = "<?php echo $presentationType; ?>" readonly>
                        
                        Registration Expense ($): <input type="double" name = "registration" value = "<?php echo $registration; ?>" readonly>
                        Transportation Expense ($): <input type="double" name = "transportation" value = "<?php echo $transportation; ?>" readonly>    
                        Accommodation Expense ($): <input type="double" name = "accomendation" value = "<?php echo $accomendation; ?>" readonly>
						Meals Expense ($): <input type="double" name = "meals" value = "<?php echo $meals; ?>" readonly>
                        Advanced Funds (optional) ($): <input type="double" name = "advanced" value = "<?php echo $advanced; ?>" readonly>
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
