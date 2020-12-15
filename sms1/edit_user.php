<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
require_once('connect.php');
?>
<style>
.control-label{
	color:#000;
	font-weight:bold;
}
.form-control{
	color:#000;
	border:1px solid;
}
</style>      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			 <div class="row">
					<ol class="breadcrumb">
						<li><i class="fa fa-angle-double-right"></i><a href="index.php">&nbsp; Home</a></li>
						<li style="color:#1a1a1a;">
            <?php
              if(isset($_GET['active'])){ 
                $active = explode("_",$_GET['active']);
                
                foreach($active as $name){
                  echo ucfirst($name);
                  echo " ";
                }
              }
            ?>
            </li> 					  	
					</ol>
				</div>>
              
		<div class="row">
        	<div class="col-md-6 col-md-offset-5">
            <?php
				if(!empty($_POST)){

          if($_POST['currentPass'] <> '' && $_POST['newPass'] <> ''){

            if(md5($_POST['currentPass']) == $_SESSION['userPass']){
                if($_POST['newPass'] <> $_POST['rPass']){
                  echo "<font color='#FF0000' size='+1'><b>Sorry! Re-enter Password miss match</b></font>";  
                }else{
                  $newPass = md5($_POST['newPass']);
                  $update = $mysqli->query("update user set full_name = '$_POST[full_name]', user_name = '$_POST[userName]', user_type = '$_POST[userType]', pass = '$newPass' where id = '$_POST[userId]'");
                  
                  if($update){
                    echo "<font color='#009900' size='+1'><b>User Updated</b></font>";  
                    unset($_SESSION['userPass']);
                    $_SESSION['userPass'] = $newPass;
                  }else{
                    echo "<font color='#FF0000' size='+1'><b>Failed</b></font>";  
                  }
                }
            }else{
              echo "<font color='#FF0000' size='+1'><b>Sorry! Current Password miss match</b></font>";
            }
          }else{
						$update = $mysqli->query("update user set full_name = '$_POST[full_name]', user_name = '$_POST[userName]', user_type = '$_POST[userType]' where id = '$_POST[userId]'");
						
						if($update){
							echo "<font color='#009900' size='+1'><b>User Updated</b></font>";	
						}else{
							echo "<font color='#FF0000' size='+1'><b>Failed</b></font>";	
						}
          }
				}
			?>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">User Update Information</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                    
                      <div class="form">
                      <?php
					  $getUserData = $mysqli->query("select * from user where id = '$_GET[userId]'");
					  $array = $getUserData->fetch_array();
					  ?>
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" action="" method="post">
                                          <!-- Title -->
                                          <input type="hidden" value="<?php echo $_GET['userId']; ?>" name="userId">
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="userType">User Type</label>
                                            <div class="col-lg-8"> 
                                                <select name="userType" class="form-control" required id="userType">
                                                	<option value="<?php echo $array['user_type']; ?>"><?php echo $array['user_type']; ?></option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="User">User</option>
                                                </select>
                                            </div>
                                          </div>   
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="full_name">Full Name</label>
                                            <div class="col-lg-8"> 
                                              <input type="text" class="form-control" id="full_name" value="<?php echo $array['full_name']; ?>" autoComplete="off" required name="full_name">
                                            </div>
                                          </div>   
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="userName">Username</label>
                                            <div class="col-lg-8"> 
                                              <input type="text" class="form-control" id="userName" autoComplete="off" value="<?php echo $array['user_name']; ?>" required name="userName">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="currentPass">Current Password</label>
                                            <div class="col-lg-8"> 
                                              <input type="password" class="form-control" id="currentPass" autoComplete="off" value="" name="currentPass">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="newPass">New Password</label>
                                            <div class="col-lg-8"> 
                                              <input type="password" class="form-control" id="newPass" autoComplete="off" value="" name="newPass">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-lg-4" for="rPass">Re-enter Password</label>
                                            <div class="col-lg-8"> 
                                              <input type="password" class="form-control" id="rPass" autoComplete="off" value="" name="rPass">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                             <!-- Buttons -->
											 <div class="col-lg-offset-5 col-lg-9">
												<button type="submit" class="btn btn-primary">Update</button>
											 </div>
                                          </div>
                                      </form>
                                    </div>
                  

                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div>
              </div>
              
            </div>       
          </div> 
              <!-- project team & activity end -->

          </section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>