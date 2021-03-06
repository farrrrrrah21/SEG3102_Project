<?php
session_start();
if ($_SESSION['loggedIn'] == false) {
	header("Location: ../index.php?action=login");
}
if ($_SESSION['userType'] != 'Supervisor') {
	include "../403.php";
	die();
}

$dbconn = mysqli_connect("localhost","root","", "d3");
$LoginID = $_SESSION['loginId'];

//get applications
$getAllQuery = "select applicationNumber, presentationDetail, applicationStatus from applicationrequest where supervisor = '".$LoginID."'";
$allApplications = mysqli_query($dbconn, $getAllQuery) or die ("Applications were not found ".mysqli_error($dbconn));
$applications = mysqli_fetch_all($allApplications);
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
                <a class="navbar-brand" href="supervisor.php">Supervisor</a>
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
                            Applications
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

               
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12" style = "height:100vh;">
                       
                       <?php
							if ($applications != null) {
								$superApproval = null;
								$refused = null;
								$incomplete = null;
								$faculty = null;
								foreach ($applications as $app) {
									if ($app[2] == "Pending Supervisor Approval") {
										$superApproval = $superApproval."<a href='editApplication.php?app=".$app[0]."'>".$app[1]."</a><br>";
									}
									if ($app[2] == "Refused") {
										$refused = $refused."<a href='editApplication.php?app=".$app[0]."'>".$app[1]."</a><br>";
									}
									if ($app[2] == "Incomplete") {
										$incomplete = $incomplete."<a href='editApplication.php?app=".$app[0]."'>".$app[1]."</a><br>";
									}
									if ($app[2] == "Pending Faculty Evaluation") {
										$faculty = $faculty."<a href='editApplication.php?app=".$app[0]."'>".$app[1]."</a><br>";
									}
								}
								if ($superApproval != null) {
									echo "<ol class='breadcrumb'><li class='active'><i class=''></i>Applications Pending Approval</li></ol>";
									echo $superApproval;
								}
								if ($incomplete != null) {
									echo "<br><ol class='breadcrumb'><li class='active'><i class=''></i>Incomplete Applications</li></ol>";
									echo $incomplete;
								}
								if ($faculty != null) {
									echo "<br><ol class='breadcrumb'><li class='active'><i class=''></i>Approved Applications</li></ol>";
									echo $faculty;
								}
								if ($refused != null) {
									echo "<br><ol class='breadcrumb'><li class='active'><i class=''></i>Applications Refused</li></ol>";
									echo $refused;
								}
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
