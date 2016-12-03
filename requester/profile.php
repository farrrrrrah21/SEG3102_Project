<?php
session_start();
if ($_SESSION['loggedIn'] == false) {
	header("Location: ../index.php?action=login");
}
if ($_SESSION['userType'] != 'Requester') {
	include "../403.php";
	die();
}

$updated = false;
$dbconn = mysqli_connect("localhost","root","", "d3");
$LoginID = $_SESSION['loginId'];

//get applications
$getAllQuery = "select applicationNumber, presentationDetail from applicationrequest where LoginId = '".$LoginID."'";
$allApplications = mysqli_query($dbconn, $getAllQuery) or die ("Applications were not found ".mysqli_error($dbconn));
$applications = mysqli_fetch_all($allApplications);

//get existing profile data
$profileData = mysqli_query($dbconn, "select * from Requester where LoginId='$LoginID'") or die ("Please update requester profile first ".mysqli_error($dbconn));

if (!empty($_POST['studentNumber'])) {
	$studentNum = stripcslashes($_POST['studentNumber']);
	$academic = stripcslashes($_POST['academicUnit']);
	$program = stripcslashes($_POST['program']);
	$session = stripcslashes($_POST['sessionNumber']);
	$thesis = stripcslashes($_POST['thesis']);
	$bank = stripcslashes($_POST['bankAccount']);
	$request = stripcslashes($_POST['requestType']);
	
	$studentNum = mysqli_real_escape_string($dbconn, $studentNum);
	$academic = mysqli_real_escape_string($dbconn, $academic);
	$program = mysqli_real_escape_string($dbconn, $program);
	$session = mysqli_real_escape_string($dbconn, $session);
	$thesis = mysqli_real_escape_string($dbconn, $thesis);
	$bank = mysqli_real_escape_string($dbconn, $bank);
	$request = mysqli_real_escape_string($dbconn, $request);
}

if (!empty($_POST['studentNumber']) && mysqli_fetch_array($profileData) == null) {
	$insertProfileQuery = "insert into Requester values("
		."'".$LoginID."', "
		."'".intval($studentNum)."', "
		."'".$academic."', "
		."'".$program."', "
		."'".intval($session)."', "
		."'".$thesis."', "
		."'".intval($bank)."', "
		."'".$request."'"
		.")";
		
	$result = mysqli_query($dbconn, $insertProfileQuery) or die ("Profile insertion failed ".mysqli_error($dbconn));
	$updated = "Profile updated successfully.";
} elseif (!empty($_POST['studentNumber']) && $profileData != null) {
	$updateProfileQuery = "update Requester set "
		."studentNumber = '".intval($studentNum)."', "
		."academicUnit = '".$academic."', "
		."program = '".$program."', "
		."sessionNumber = '".intval($session)."', "
		."Thesis_Topic = '".$thesis."', "
		."BankAccountNumber = '".intval($bank)."', "
		."RequestType = '".$request."' "
		."where LoginId = '".$LoginID."'";
	
	$result = mysqli_query($dbconn, $updateProfileQuery) or die ("Profile update failed ".mysqli_error($dbconn));
	$updated = "Profile updated successfully.";
}

$studentNumber = "";
$academicUnit = "";
$program = "";
$sessionNumber = "";
$thesis = "";
$bankAccount = "";
$requestType = "";
$supervisor = "";

$profileData = mysqli_query($dbconn, "select * from Requester where LoginId='$LoginID'") or die ("Please update requester profile first ".mysqli_error());
$profile = mysqli_fetch_array($profileData);
if ($profile != null) {
	if ($profile['studentNumber'] != null) {
		$studentNumber = $profile['studentNumber'];
	}
	if ($profile['academicUnit'] != null) {
		$academicUnit = $profile['academicUnit'];
	}
	if ($profile['program'] != null) {
		$program = $profile['program'];
	}
	if ($profile['sessionNumber'] != null) {
		$sessionNumber = $profile['sessionNumber'];
	}
	if ($profile['Thesis_Topic'] != null) {
		$thesis = $profile['Thesis_Topic'];
	}
	if ($profile['BankAccountNumber'] != null) {
		$bankAccount = $profile['BankAccountNumber'];
	}
	if ($profile['RequestType'] != null) {
		$requestType = $profile['RequestType'];
	}
	if ($profile['supervisor'] != null) {
		$supervisor = $profile['supervisor'];
		$superData = mysqli_query($dbconn, "select first_name, last_name from users where LoginId='$supervisor'") or die ("Supervisor does not exist. ".mysqli_error($dbconn));
		$super = mysqli_fetch_array($superData);
		$supervisor = $super['first_name']." ".$super['last_name'];
	}
}

//get existing user data
$userData = mysqli_query($dbconn, "select * from users where LoginId='$LoginID'") or die ("Please update requester profile first ".mysqli_error());
$data = mysqli_fetch_array($userData);

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
                <a class="navbar-brand" href = "requester.php" >Requester</a>
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
                            Profile
                        </h1>
						<?php
							if ($updated != false) {
								echo "<h4 style='color:green;'>$updated</h4>";
							}
						?>
                        <ol class="breadcrumb">
                            
                            <li class="active">
                                <i class=""></i>Create Profile
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               
          

                <!-- Morris Charts -->
                <div class="row">
                    <div class="col-lg-12">
                        


                    


                        <form action="profile.php" method = "POST" > 
                        <input type="text" placeholder="First Name" name = "firstName" value = "<?php echo $data['first_name']; ?>" readonly>
                        <input type="text" placeholder="Last Name" name = "lastName" value = "<?php echo $data['last_name']; ?>" readonly>
						<input type="text" placeholder="Email" name = "email" value = "<?php echo $data['email']; ?>" readonly>
						<input type="text" placeholder="Supervisor" name = "supervisor" value = "<?php echo $supervisor; ?>" readonly>
						<input type="text" placeholder="Student Number" name = "studentNumber" value = "<?php echo $studentNumber; ?>" pattern="[0-9]{1,11}" required>
						<input type="text" placeholder="Academic Unit" name = "academicUnit" value = "<?php echo $academicUnit; ?>" required>
						<input type="text" placeholder="Program of Studies" name = "program" value = "<?php echo $program; ?>" required>
                        <input type="double" placeholder="Session Number" name = "sessionNumber" value = "<?php echo $sessionNumber; ?>" pattern="[0-9]{1,11}" required>
						<input type="text" placeholder="Thesis Topic" name = "thesis" value = "<?php echo $thesis; ?>" required>
						<input type="text" placeholder="Bank Account Number" name = "bankAccount" value = "<?php echo $bankAccount; ?>" pattern="[0-9]{1,11}" required>
                        <input type="text" placeholder="Request Type" name = "requestType" value = "<?php echo $requestType; ?>" required>
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
