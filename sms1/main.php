<?php
ob_start();
session_start();
require_once('connect.php');
if(isset($_SESSION['userId'])){
	header("Location:dashboard.php?active=dashboard");
}else{
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | <?php
                                      $labsql = "SELECT * FROM lab_info WHERE id=1";
                                      $result = $mysqli->query($labsql); 
                                      while ($row = $result->fetch_assoc()) {
                                        echo $row['lab_name'];
                                       }
                                    ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon.png">

	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	

<style>
 box-sizing{
  width: 400px;
  padding: 10px;
  border: 5px solid gray;
  margin: 0;
}


span.input-icon, span.input-help {
  display: block;
  position: relative;
}

.input-icon > input {
  padding-left: 30px !important;
  padding-right: 6px;
}

.input-icon.input-icon-right > input {
  padding-left: 6px !important;
  padding-right: 30px !important;
}

span.input-help > input {
  padding-left: 30px;
  padding-right: 6px;
}

.input-icon > [class*="fa-"], .input-icon > [class*="ti-"] {
  bottom: 0;
  color: #007AFF;
  display: inline-block;
  left: 5px;
  line-height: 35px;
  padding: 0 3px;
  position: absolute;
  top: -1px;
  z-index: 2;
}

.input-icon.input-icon-right > [class*="fa-"], .input-icon.input-icon-right > [class*="ti-"] {
  left: auto;
  right: 4px;
}
</style>

</head>

<body class="login">
    <?php
			if (isset($_POST['submit'])) {
				
				$userTypeInput = $_POST['userType'];
				$userNameInput = $_POST['userName'];
				$userPassInput = md5($_POST['userPass']);
				//$userPassInput = $_POST['userPass'];
				
				$loginSql = "SELECT * FROM user WHERE "
							."user_name = '$userNameInput'"
							."and pass = '$userPassInput'"
							."and user_type = '$userTypeInput'";
				
				$query = $mysqli->query($loginSql) or die($mysqli->error);
				$count = $query->num_rows;
				
				if($count == 1){
						$array = $query->fetch_array();
						$_SESSION['userId'] = $array['id'];
						$_SESSION['fullName'] = $array['full_name'];
						$_SESSION['userName'] = $array['user_name'];
                        $_SESSION['userPass'] = $array['pass'];
						$_SESSION['userType'] = $array['user_type'];
						header("Location:dashboard.php?active=dashboard");
				}else{
					$error="Sorry! Wrong Username/Password";
				}

			}
		?>
	<!-- WRAPPER -->
	<div id="wrapper">
	<!--	<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
					<div class="middle">-->

<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
<!--	<div class="vertical-align-wrap">-->
	
	
						<div class="box-login">

							<br>
							<p align="center">
								<h2><font color="black">Login Details</font></h2>
							</p>

	<div class="panel panel-white no-radius text-center">
		<div class="panel-body">

						<div class="box-sizing">
      <fieldset>
							<legend>
							<h4><p align="left"><font color="#007AFF"  font-family="Lato">Sign in to your account</font></p></h4>
							</legend>
							
						<!--	<div class="header">
								<div class="logo text-center"><img style="height:150px;" src="assets/img/logo.png" alt=" Diagnostic Centre"></div>
								
							</div>-->
								
							<p style='color:#F00; font-weight:bold'>
								
					            <?php if(isset($error)){echo $error;}?>
							</p>
							<form class="form-auth-small" method="post">
								<h5><p align="left">Please enter your name and password to log in.</p></h5>

							    <div class="form-group">
									<select name="userType" class="form-control" required>
					                	<option value="">--Select User Type--</option>
					                    <option value="Administrator">Administrator</option>
					                    <option value="User">User</option>
					                    <option value="Pathology">Pathology</option>
					                </select>
								</div>
								<div class="form-group">
									<span class="input-icon">
								<!--	<label for="signin-email" class="control-label sr-only">Username</label>-->
                                    <input type="text" class="form-control" placeholder="Username" name="userName" id="signin-email" required >
									<i class="fa fa-user"></i> 
</span>
								</div>
								<div class="form-group">
									<span class="input-icon">
									<!--<label for="signin-password" class="control-label sr-only">Password</label>-->
									<input type="password" class="form-control" id="signin-password" name="userPass" placeholder="Password" required >
									<i class="fa fa-lock"></i>
								</span>
								</div>
								
								<button type="submit" name="submit" class="btn btn-primary pull-right">LOGIN <i class="fa fa-arrow-circle-right"></i></button>
								
							</form>
							 <fieldset>
						</div>
					</div>

					<div class="clearfix"></div>
					<br>
					<div class="copyright">
					<center>	&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Dr. Lad's Nath Pathology</span>. <span>All rights reserved</span></center>
					</div>
</div>
			</div>

		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
<?php
}
?>
