<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'User')){
require_once('include/header.php');
require_once('connect.php');
date_default_timezone_set('UTC');
$mkdate = mktime(date('H') + 6, date('i'), date('s'));
$date = date('Y-m-d', $mkdate);
$time = date('h:i:s', $mkdate);
?>

<script>
$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>
<style>
.input-group{
	margin-bottom:10px;
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
            	<div class="col-lg-12" align="center">
                	<?php
					if(isset($_GET['delete']) && $_GET['delete'] <> ''){
						echo "<font color='#FF0000'><b>Delete Successed</b></font>";	
					}
					?>
                </div>
            </div>
            <div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Test Name</th>
                            <th>Category</th>
                            <th>Rate</th>
                            <th>Refd Fee(%)</th>
                            <th>Refd Fee Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Test Name</th>
                        <th>Category</th>
                        <th>Rate</th>
                        <th>Refd Fee(%)</th>
                        <th>Refd Fee Amount</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
					$query = $mysqli->query("select * from tests join test_category on tests.testCategoryId = test_category.categoryId order by  test_category.categoryId asc");
					if($query->num_rows > 0){
						$sl = 1;
						while($rows = $query->fetch_array()){
						?>
						<tr>
							<td><?php echo $sl; ?></td>
							<td><?php echo $rows['testName']; ?></td>
                            <td><?php echo $rows['categoryName']; ?></td>
                            <td><?php echo $rows['rate']; ?></td>
                            <td><?php echo $rows['refdFeeRatePer']; ?></td>
                            <td><?php echo $rows['refdFeeAmount']; ?></td>
							<td align="center"><a href="edit_test.php?active=test&testId=<?php echo $rows['testId']; ?>">Edit</a>&nbsp;&nbsp;<a href="delete_test.php?testId=<?php echo $rows['testId']; ?>" onClick="return confirm('Are you sure want to delete?')">Delete</a></td>
						</tr>
						<?php
						$sl++;
						}
					}
					?>
                    </tbody>  
                    </table> 
                     </div>
				</div><!--/.col-->
			</div><!--/.row-->
            
		</section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>