<?php
ob_start();
session_start();

	require_once('include/header.php');
	require_once('connect.php');
?>
<?php
date_default_timezone_set('UTC');
$mkdate = mktime(date('H') + 6, date('i'), date('s'));
$date = date('Y-m-d', $mkdate);
?>
<div class="row">
                  <div class="col-lg-12">
					<div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Refd By</th>
                            <th>C/O</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Refd By</th>
                        <th>C/O</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
				
						$condition = "where isCancel = '0' and date=$date ";
					   //echo $condition;
					echo $date;
					$query = $mysqli->query("select * from invoice  where  invoiceDate='$date' order by invoiceId desc");
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
                            <td><?php echo $refdArray['doctor_name']; ?></td>
                            <td><?php echo $coArray['coName']; ?></td>
                            <td>
								<?php
									$resultDate = new DateTime($rows['date']);
									echo $resultDate->format('d-m-Y');
								?>
                            </td>
                            <td>
								<?php
									$resultTime = new DateTime($rows['time']);
									echo $resultTime->format('h:i:s A');
								?>
                            </td>
							<td align="center">
                            <a href="pathology.php?active=pathology&idNo=<?php echo $rows['idNo']; ?>">Add Report</a>
                            <a href="urine_report_edit.php?idNo=<?php echo $rows['idNo']; ?>&active=urine_report">Edit</a>
                              <a href="urine_report_delete.php?idNo=<?php echo $rows['idNo']; ?>" onclick="return confirm('Are you sure to Remove this')">Remove</a>
                            </td>
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