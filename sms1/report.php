<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
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
function searchByDate(){
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();

	if(from_date.length > 0 && to_date.length > 0){
		from_date = from_date.split('/');
		from_date = from_date[2]+'-'+from_date[0]+'-'+from_date[1];
		
		to_date = to_date.split('/');
		to_date = to_date[2]+'-'+to_date[0]+'-'+to_date[1];
		
		window.location = 'report.php?active=report&from_date='+from_date+'&to_date='+to_date;
	}else{
		alert('Date field empty!');
	}
	
}

</script>
<style>
.input-group{
	margin-bottom:10px;
}
.form-row input {
    width: 220px;
    padding: 3px 1px;
    border: 1px solid #090;
    box-shadow: none;
}
</style>     
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			  <div class="row">
					<h1>Manage Patient</h1>
				</div>
         <div class="row">
              <!--  <div class="col-sm-4">-->
                  <div class="panel panel-white no-radius">
                    <div class="panel-body">
            <center>
            	<div class="row">
                	<div class="col-lg-12">
                    <div class="container-fluid container-fullw bg-white">
                      <div class="container-fluid container-fullw bg-white">
             
                      <br>
              <div class="row">
              <!--  <div class="col-sm-4">-->
                 
                    	<!--<button class="btn btn-primary" onclick="report()">Report</button>-->
                        <?php
						if(isset($_GET['delete']) && $_GET['delete'] <> '')
						{
							echo "<center><font color='#F00'><b>Cancel Successed</font></center>";
						}
						?>
                    </div>
               </div>
               <div class="row">
               	<div class="col-lg-12" align="center">
                	<?php
					if(isset($_GET['action']) == 'delete'){
						echo "<font color='#FF0000'><b>Delete Successed</b></font>";	
					}
					?>
                </div>
               </div>
           <!--    <div class="row">
               	<div class="col-lg-12">
                	<div class="form-row show-inputbtns" align="center">
                        <input type="text" id="from_date" /> To
                        <input type="text" id="to_date" />
                        <button class="btn btn-primary" onclick="searchByDate()">Search</button>
                    </div>
                </div>
               </div>-->
               </center>
                  
                  <div class="row">
                  <div class="col-lg-12">
					<div class="table-responsive">
                    <table id="myTable" class="table table-bordered"cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>UH ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                       <!--     <th>Refd By</th>
                            <th>C/O</th>
                            <th>Date</th>
                            <th>Time</th>-->
                            <th><center>Action</center></th>
                        </tr>
                    </thead>
                   
                   
                    <tbody>

                    <?php
					if(isset($_GET['from_date']) <> '' && isset($_GET['to_date']) <> ''){
						$condition = "where invoice.isCancel = '0' and path_result_pages.resultDate between '$_GET[from_date]' and '$_GET[to_date]'";
					}else{
						$condition = "where invoice.isCancel = '0'";	
					}
					
					$query = $mysqli->query("select * from invoice join path_result_pages on invoice.idNo = path_result_pages.idNo $condition order by invoiceId desc");
					if($query->num_rows > 0){
						$sl = 1;
						$price = 0;
						while($rows = $query->fetch_array()){
							$getCO = $mysqli->query("select * from co where coId = '$rows[coId]'");
							$coArray = $getCO->fetch_array();
							
							$getRefd = $mysqli->query("select * from doctor where id = '$rows[refdId]'");
							$refdArray = $getRefd->fetch_array();
						?>
						<tr>
							<td><?php echo $sl; ?></td>
                            <td><?php echo $rows['idNo']; ?></td>
                            <td><?php echo $rows['patientName']; ?></td>
                            <td><?php echo $rows['patientMobile']; ?></td>
                          <!--  <td><?php echo $refdArray['doctor_name']; ?></td>
                            <td><?php echo $coArray['coName']; ?></td>
                            <td>-->
						<!--		<?php
									$resultDate = new DateTime($rows['resultDate']);
									echo $resultDate->format('d-m-Y');
								?>
                            </td>
                            <td>
								<?php
									$resultTime = new DateTime($rows['resultTime']);
									echo $resultTime->format('h:i:s A');
								?>
                            </td>-->
							<td align="center">
                        <center> <a href="addnewtest.php?idNo=<?php echo $rows['idNo']; ?>">Add Test</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                           <a href="report_details.php?idNo=<?php echo $rows['idNo']; ?>">Report</a> 
                            
                            </td>
						</tr>
						<?php
						$sl++;
						}
					}
					?>
                    </tbody> 
                    <br> 
                    </table> 
                     </div>
				</div><!--/.col-->
			</div><!--/.row-->

            </div>
          </div>
        </div>
      </div>

		</section>

  </center>
</td>
<br>
<br>


<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>