<?php
ob_start();
session_start();
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


});

function pathologyEdit(reportId, fieldName){
    $('#'+fieldName+'_input_'+reportId).show();
    $('#'+fieldName+'_'+reportId).hide();
}

function pathologyEditAction(reportId, fieldName, values){

    if(values.length < 1){
        alert('Please enter something!');
    }else{

        $.ajax({
            type: 'POST',
            url: 'change_pathology_data.php',
            data: 'reportId='+reportId+'&fieldName='+fieldName+'&values='+values,
            success:function(data){

                $('#'+fieldName+'_'+reportId).html(values);

                $('#'+fieldName+'_'+reportId).show();
                $('#'+fieldName+'_input_'+reportId).hide();
            }
        });

    }
}
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
				</div>
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
                            <th>Result Details</th>
                            
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Test Name</th>
                        <th>Result Details</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $query = $mysqli->query("select * from report_content join tests on report_content.testId = tests.testId order by report_content.reportContentId asc");
                    if($query->num_rows > 0){
                        $sl = 1;
                        while($rows = $query->fetch_array()){
                            $query2 = $mysqli->query("select * from report where reportContentId = '$rows[reportContentId]' order by reportId ASC");
                        ?>
                        <tr>
                            <td><?php echo $sl; ?></td>
                            <td><?php echo $rows['testName']; ?></td>
                            <td>
                                <table width="100%" border="0">
                                <tr>
                            <?php
                                while($rows2 = $query2->fetch_array()){
                                ?>
                                    <?php
                                    if($rows2['resultName'] <> ''){
                                    ?>
                                    <td width="">
                                        <input type="text" style="display: none;" name="" class="input-control" id="resultName_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'resultName', this.value)" value="<?php echo $rows2['resultName']; ?>">
                                        
                                        <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'resultName')" id="resultName_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['resultName'];?></span>

                                    </td>
                                    <?php
                                    }
                                    if($rows2['defaultValue'] <> ''){
                                    ?>
                                    <td width="">
                                        <input type="text" style="display: none;" name="" class="input-control" id="defaultValue_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'defaultValue', this.value)" value="<?php echo $rows2['defaultValue']; ?>">
                                    
                                        <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'defaultValue')" id="defaultValue_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['defaultValue'];?></span>
                                    </td>
                                    <?php
                                    }
                                    if($rows2['unit'] <> ''){
                                    ?>
                                        <td width="">
                                            <input type="text" style="display: none;" name="" class="input-control" id="unit_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'unit', this.value)" value="<?php echo $rows2['unit']; ?>">
                                    
                                            <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'unit')" id="unit_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['unit'];?></span>
                                        </td>
                                    <?php
                                    }
                                    if($rows2['rangeValue'] <> ''){
                                    ?>
                                        <td width="">
                                            <input type="text" style="display: none;" name="" class="input-control" id="rangeValue_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'rangeValue', this.value)" value="<?php echo $rows2['rangeValue']; ?>">
                                    
                                            <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'rangeValue')" id="rangeValue_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['rangeValue'];?></span>
                                        </td>
                                    <?php
                                    }
                                    
                                    if($rows2['calculationValue'] <> ''){
                                    ?>
                                        <td> = 
                                            <input type="text" style="display: none;" name="" class="input-control" id="calculationValue_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'calculationValue', this.value)" value="<?php echo $rows2['calculationValue']; ?>">
                                    
                                            <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'calculationValue')" id="calculationValue_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['calculationValue'];?></span>
                                        </td>
                                        <td>
                                            <input type="text" style="display: none;" name="" class="input-control" id="calculationUnit_input_<?php echo $rows2['reportId']; ?>" onChange="pathologyEditAction(<?php echo $rows2['reportId']; ?>, 'calculationUnit', this.value)" value="<?php echo $rows2['calculationUnit']; ?>">
                                    
                                            <span onClick="pathologyEdit(<?php echo $rows2['reportId']; ?>, 'calculationUnit')" id="calculationUnit_<?php echo $rows2['reportId']; ?>"><?php echo $rows2['calculationUnit'];?></span>

                                        </td>
                                    <?php
                                    }
                                }
                            ?>
                                    
                                </tr>
                                </table>
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
            
        </section>

<?php
require_once('include/footer.php'); 
}else{
    header("Location:index.php");   
}
?>