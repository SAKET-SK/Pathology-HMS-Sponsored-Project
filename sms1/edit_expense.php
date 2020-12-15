<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
	require_once('include/header.php');
	require_once('connect.php');?>
	<script>
$(document).ready(function() {
	$('#myTable').DataTable();
} );
</script>

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
				</div>

<?php
	$get_id=$_GET['id'];
	$query1 = $mysqli->query("select * from expense_details where Id='$get_id'");
	$row1 = $query1->fetch_array();

	//$emp_id = $row1['emp_id'];
	
	//$query2 = $mysqli->query("select * from employee_title where emp_id='$emp_id'");
	//$row2 = $query2->fetch_array();
?>
<div class="col-md-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">Edit Expense</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
	<form action="edit_expense.php" method="post">

		<!-- the id need to be sent by the form to receive from the submitted form -->
		<input type="hidden" name="id" value="<?php echo $get_id;?>"/>

	Expense Title
	<br>
	<?php
		$result = $mysqli->query("select * from employee_title");
    
    		echo "<html>";
    		echo "<select name='emp_id'>";

    		while ($row = $result->fetch_assoc()) {
    			unset($id, $title);
    			$id = $row['emp_id'];
                $title = $row['title']; 
                if($row1['emp_id']==$id){
                    echo "<option value='" . $id."' selected>" . $title ."</option>";
                    
                } 
                else 
                    echo "<option value='" . $id."'>" . $title ."</option>";
            }

    		echo "</select>";
    		echo "</html>";?>

	<br>
	Amount
	<input type="number" name="amount" value="<?php echo $row1['amount'];?>" required/>
	<br><br>
	Details
	<textarea name="details" required><?php echo $row1['details'];?></textarea>
	<br><br>
	<button type="submit" class="btn btn-primary" name="submit" >Update Expense</button>
	</form>
	</div>
	</div>
	</div>
</div>

<?php
    date_default_timezone_set('Asia/Dhaka');
	$date = date('Y-m-d H:i:s');

	if ( isset($_POST['submit']) ) {
		$emp_id = trim($_POST['emp_id']);
		//$exp_type= trim($_POST['exp_type']);
		$amount = trim($_POST['amount']);
		$details = trim($_POST['details']);

		$get_id=$_POST['id'];
		//$emp_id=$_POST['emp_id'];
		
// 		var_dump($emp_id);
// 		var_dump($get_id);


		$sql = $mysqli->query("update expense_details set emp_id='$emp_id', date='$date', amount='$amount', details='$details' where Id='$get_id'");
		//$sql2 = $mysqli->query("update employee_title set title='$title' where emp_id='$emp_id'");
		
		header("Location:expense_list.php");

	}?>
</section>
	<?php
	require_once('include/footer.php');
}
else
	header("Location:index.php");?>
