<?php
ob_start();
@session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
require_once('connect.php');
?>

<script>
$(function(){
	$('#categoryId').change(function(){
		
		var id = this.value;
		
		$.ajax({
			type: "POST",
			url: "get_test_by_category.php",
			data: "categoryId="+id,
			success: function(data){
				$('#testId').html(data);
			}
		});
	});
	
	$("#header").typeahead({
		source:function(query, process){
			$.getJSON('get_header.php?query='+query, function(data){
				process(data);
			});
		}
	});
})
</script>
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
				</div>
              
		<div class="row">
        	<div class="col-md-6 col-md-offset-5">
            <?php
				if(!empty($_POST)){
					
						if(isset($_POST['IsBasic'])){
							$hBasic = 1;	
						}else{
							$hBasic = 0;
						}
					
						$update = $mysqli->query("update pathology set testId = '$_POST[testId]', header = '$_POST[header]', isBasic = '$hBasic' where pathologyId = '$_POST[pathologyId]'");
						
						$update = $mysqli->query("update pathology_header_meta set cValue = '$_POST[hCValue]', cUnit = '$_POST[hCUnit]', resultUnit = '$_POST[hunit]', fieldsReferenceRange = '$_POST[hrange]', isBasic = '$hBasic' where pathologyHeaderMetaId = '$_POST[pathologyHeaderMetaId]' and pathologyId = '$_POST[pathologyId]'");
						
						$update = $mysqli->query("update pathology_meta set resultName = '$_POST[fieldName]', cValue = '$_POST[CValue]', cUnit = '$_POST[CUnit]', resultUnit = '$_POST[unit]', fieldsReferenceRange = '$_POST[range]', isBasic = '$hBasic' where pathologyMetaId = '$_POST[pathologyMetaId]' and pathologyId = '$_POST[pathologyId]'");
						
						if($update){
							echo "<font color='#009900' size='+1'><b>Pathology Updated</b></font>";	
						}else{
							echo "<font color='#FF0000' size='+1'><b>Failed</b></font>";	
						}
				}
			?>
            </div>
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="pull-left">Pathology Update Information</div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                    
                      <div class="form">
                      <?php
					  $getTestData = $mysqli->query("select * from pathology join tests on pathology.testId = tests.testId where pathology.pathologyId = '$_GET[pathologyId]'");
					  $array = $getTestData->fetch_array();
					  
						$pathology_header_meta = $mysqli->query("select * from pathology_header_meta where pathologyHeaderMetaId = '$_GET[pathologyHeaderMetaId]' and pathologyId = '$array[pathologyId]'");
						$hmArray = $pathology_header_meta->fetch_array();
						
						$pathology_meta = $mysqli->query("select * from pathology_meta where pathologyMetaId = '$_GET[pathologyMetaId]' and pathologyId = '$array[pathologyId]'");
						$mArray = $pathology_meta->fetch_array();
					  ?>
                                      <!-- Edit profile form (not working)-->
                                      <form class="form-horizontal" action="" method="post">
                                          <!-- Title -->
                                          <input type="hidden" name="pathologyId" value="<?php echo $_GET['pathologyId']; ?>">
                                          <input type="hidden" name="pathologyHeaderMetaId" value="<?php echo $_GET['pathologyHeaderMetaId']; ?>">
                                          <input type="hidden" name="pathologyMetaId" value="<?php echo $_GET['pathologyMetaId']; ?>">
                                          <div class="col-md-6">
                                          	<div class="form-group">
                                                <label class="control-label col-lg-4" for="categoryId">Category</label>
                                                <div class="col-lg-8"> 
                                                  <?php
                                                    $category0 = $mysqli->query("select * from test_category where categoryId = '$array[testCategoryId]'");
                                                    $catArray = $category0->fetch_array();
                                                    
                                                    $category = $mysqli->query("select * from test_category where is_path = '1' order by categoryId asc");
                                                    ?>
                                                    <select name="categoryId" class="form-control" required id="categoryId">
                                                        <option value="<?php echo $catArray['categoryId']; ?>"><?php echo $catArray['categoryName']; ?></option>
                                                        <?php
                                                        while($categoryRow = $category->fetch_array()){
                                                        ?>
                                                        <option value="<?php echo $categoryRow['categoryId']; ?>"><?php echo $categoryRow['categoryName']; ?></option>
                                                        <?php	
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="testId">Test Name</label>
                                                <div class="col-lg-8"> 
                                                  <select name="testId" class="form-control" required id="testId">
                                                    <option value="<?php echo $array['testId']; ?>"><?php echo $array['testName']; ?></option>
                                                </select>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="header">Header</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="header" autoComplete="off" name="header" value="<?php echo $array['header']; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="hunit">Header Unit</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="hunit" autoComplete="off" name="hunit" value="<?php echo $hmArray['resultUnit']; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="hrange">Header Reference Range</label>
                                                <div class="col-lg-8"> 
                                                  <textarea class="form-control" id="hrange" name="hrange"><?php echo $hmArray['fieldsReferenceRange']; ?></textarea>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="hCUnit">Header CUnit</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="hCUnit" value="<?php echo $hmArray['cUnit']; ?>" autoComplete="off" name="hCUnit">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="hCValue">Header CValue</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="hCValue" autoComplete="off" name="hCValue" value="<?php echo $hmArray['cValue']; ?>">
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                          	<div class="form-group">
                                                <label class="control-label col-lg-4" for="fieldName">Field Name</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="fieldName" autoComplete="off" name="fieldName" value="<?php echo $mArray['resultName']; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="unit">Unit</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="unit" autoComplete="off" name="unit" value="<?php echo $mArray['resultUnit']; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="range">Reference Range</label>
                                                <div class="col-lg-8"> 
                                                  <textarea class="form-control" id="range" name="range"><?php echo $mArray['fieldsReferenceRange']; ?></textarea>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="CUnit">CUnit</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="CUnit" autoComplete="off" name="CUnit" value="<?php echo $mArray['cUnit']; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label col-lg-4" for="CValue">CValue</label>
                                                <div class="col-lg-8"> 
                                                  <input type="text" class="form-control" id="CValue" autoComplete="off" name="CValue" value="<?php echo $mArray['cValue']; ?>">
                                                  <input type="checkbox" name="IsBasic" id="IsBasic" checked="<?php if($array['isBasic']==1){ echo 'checked';}else{echo '';} ?>" />&nbsp;<label for="IsBasic" class="control-label">Is Basic</label>
                                                </div>
                                              <div class="form-group">
                                                 <!-- Buttons -->
                                                 <div class="col-lg-offset-5 col-lg-9">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                 </div>
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