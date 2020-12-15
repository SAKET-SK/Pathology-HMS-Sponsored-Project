<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
require_once('include/header.php');
require_once('connect.php');
?>
<!--<script src="js/bootstrap.js"></script>-->
<script>
$(function(){

  $(window).keydown(function(event){
    if(event.keyCode == 13){
      event.preventDefault();
      return false;
    }
  });

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
	
})

$(document).on( 'click','.add', function (e) {


     /* var keyCode = e.keyCode || e.which;*/
      var columnWidthBox = $("input[class='columnWidth']").length;
        
        $('#displayColumnWidth').append('<span class="display_columnWidth_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayReportHeader').append('<span class="display_reportHeader_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayResultName').append('<span class="display_resultName_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayInput').append('<span class="display_input_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayDefaultValue').append('<span class="display_defaultValue_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayUnit').append('<span class="display_unit_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayCalculationValue').append('<span class="display_calculationValue_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayCalculationUnit').append('<span class="display_calculationUnit_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        $('#displayRangValue').append('<span class="display_rangValue_'+columnWidthBox+'" style="padding-left:5px; padding-bottom:2px; Width:200px;"></span>');

        /* ------------------ Start Class -----------------------*/

        $('.display_columnWidth_'+columnWidthBox).html('<input type="text" autocomplete="off" name="columnWidth[]" id="columnWidth_'+columnWidthBox+'" class="columnWidth" onkeypress="f(event)" style="border: 1px solid">');

        $('.display_reportHeader_'+columnWidthBox).html('<input type="text" autocomplete="off" name="reportHeader[]" id="reportHeader_'+columnWidthBox+'" onkeydown="report_header('+columnWidthBox+')" class="reportHeader_'+columnWidthBox+'" style="border: 1px solid">');

        $('.display_resultName_'+columnWidthBox).html('<input type="text" autocomplete="off" name="resultName[]" id="resultName_'+columnWidthBox+'" class="resultName" style="border: 1px solid">');

        $('.display_input_'+columnWidthBox).html('<select name="input[]" id="input_'+columnWidthBox+'" class="input" style="width:161px; border: 1px solid"><option value="0">None</option><option value="1">Input</option></select>');

        $('.display_defaultValue_'+columnWidthBox).html('<input type="text" autocomplete="off" name="defaultValue[]" id="defaultValue_'+columnWidthBox+'" class="defaultValue" style="border: 1px solid">');

        $('.display_unit_'+columnWidthBox).html('<input type="text" autocomplete="off" name="unit[]" id="unit_'+columnWidthBox+'" class="unit" style="border: 1px solid">');

        $('.display_calculationValue_'+columnWidthBox).html('<input type="text" autocomplete="off" name="calculationValue[]" id="calculationValue_'+columnWidthBox+'" class="calculationValue" style="border: 1px solid">');

        $('.display_calculationUnit_'+columnWidthBox).html('<input type="text" autocomplete="off" name="calculationUnit[]" id="calculationUnit_'+columnWidthBox+'" class="calculationUnit" style="border: 1px solid">');

        $('.display_rangValue_'+columnWidthBox).html('<textarea name="rangeValue[]" cols="15" style="width: 161px; border: 1px solid" id="rangeValue_'+columnWidthBox+'" class="rangeValue" style="border: 1px solid"></textarea>');

        e.preventDefault();
        $('input[id="columnWidth_'+columnWidthBox+'"]').focus();
      
    });

function report_header(index){

    var reportHeader = $('input[class="reportHeader_'+index+'"]');

    $(reportHeader).typeahead({
      source:function(query, process){
        $.getJSON('get_reportheader.php?query='+query, function(data){
          process(data);
        });
      }
    });
}

</script>
<style>
.control-label{
  color:#000;
  font-weight:bold;
  cursor:pointer;
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
        	<div class="col-md-12" align="center">
            <?php
				if(!empty($_POST)){
					
					$testId = $_POST['testId'];
          $columnWidth = $_POST['columnWidth'];
          $reportHeader = $_POST['reportHeader'];
          $resultName = $_POST['resultName'];
          $isInput = $_POST['input'];
          $defaultValue = $_POST['defaultValue'];
          $unit = $_POST['unit'];
          $calculationValue = $_POST['calculationValue'];
          $calculationUnit = $_POST['calculationUnit'];
          $rangeValue = $_POST['rangeValue'];
          echo $isInput[0];echo $isInput[1];echo $isInput[2];

          $mysqli->query("insert into report_content (testId) values('$testId')");
          $getCId = $mysqli->query("select reportContentId from report_content where reportContentId in (select max(reportContentId) from report_content)");
          $array = $getCId->fetch_array();

          $i = 0;
          echo '<table width="100%" border="0" style="border-bottom:1px solid">
              <tr>';
          foreach ($columnWidth as $key => $value) {
            if($columnWidth[$key] <> ''){

              if($reportHeader[$key] <> ''){
                $getHeader = $mysqli->query("select * from report_header where reportHeader = '$reportHeader[$key]'");
                if($getHeader->num_rows > 0){
                  $hArray = $getHeader->fetch_array();
                  $headerId = $hArray['reportHeaderId'];
                }else{
                  $mysqli->query("insert into report_header (reportHeader) values('$reportHeader[$key]')");

                  $getHeader = $mysqli->query("select * from report_header where reportHeader = '$reportHeader[$key]'");
                  $hArray = $getHeader->fetch_array();
                  $headerId = $hArray['reportHeaderId'];
                }
              }else{
                $headerId = 0;
              }

              $mysqli->query("insert into report (reportContentId,columnWidth,reportHeaderId,resultName,isInput,defaultValue,unit,calculationValue,calculationUnit,rangeValue) values('$array[reportContentId]', '$columnWidth[$key]', '$headerId', '$resultName[$key]', '$isInput[$key]', '$defaultValue[$key]', '$unit[$key]', '$calculationValue[$key]', '$calculationUnit[$key]', '$rangeValue[$key]')");
              echo $mysqli->error;
              
            ?>
            
                <td width="<?php echo $columnWidth[$key]; ?>%">
                  <?php
                    if($resultName[$key] <> ''){
                      echo '<h3>'.$resultName[$key].'</h3>';
                    }
                    if($calculationValue[$key] <> ''){
                      echo $calculationValue[$key];
                    }
                    if($calculationUnit[$key] <> ''){
                      echo $calculationUnit[$key];
                    }
                    //echo $isInput[$key];
                    if($isInput[$key] == 1){
                    ?>
                      <input type="text" name="test_<?php echo $testId.'_'.$i++; ?>" value="<?php echo $defaultValue[$key]; ?>" style="border:1px solid">
                    <?php
                    }
                    if($unit[$key] <> ''){
                      echo $unit[$key];
                    }
                    if($rangeValue[$key] <> ''){
                      echo $rangeValue[$key];
                    }
                  ?>
                </td>
              
            <?php
            }
            
          }
          echo '</tr>
            </table>';
				}
			?>
            </div>
            
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="col-md-8 pull-left">New Pathology Information</div>
                  <div class="col-md-4"><p class="add " style="float:right;padding:5px;width:100px; text-align:center;background:#F25D30;color:#fff;cursor:pointer;">Add Column</p></div>
                </div>
                <div class="panel-body">
                  <div class="padd">
                      <?php
                      $category = $mysqli->query("select * from test_category where is_path = '1' order by categoryId asc");
                      ?>
                      <form action="" method="POST">
                      <table style="color:#000;">
                      <tr>
                          <td style="padding: 5px">
                            Category
                          </td>
                          <td style="padding: 5px">
                              <select name="categoryId" required id="categoryId" style="width: 161px;">
                                  <option value="">--Select One--</option>
                                  <?php
                                  while($categoryRow = $category->fetch_array()){
                                  ?>
                                  <option value="<?php echo $categoryRow['categoryId']; ?>"><?php echo $categoryRow['categoryName']; ?></option>
                                  <?php 
                                  }
                                  ?>
                              </select>
                          </td>
                      </tr>
                      
                     
                      <tr>
                          <td style="padding: 5px">
                            Test Name
                          </td>
                          <td style="padding: 5px">
                              <select name="testId" required id="testId" style="width: 161px">
                                <option value="">--Select One--</option>
                              </select>
                          </td>
                      </tr>
                      
                  
                      <tr>
                        <td style="padding: 5px">
                          Column Width
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="columnWidth[]" id="columnWidth" class="columnWidth" onkeypress="" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayColumnWidth"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Header
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="reportHeader[]" id="reportHeader" class="reportHeader_0" onkeydown="report_header(0)" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayReportHeader"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Result Name
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="resultName[]" id="resultName" class="resultName" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayResultName"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Input
                        </td style="padding: 5px">
                        <td style="padding: 5px">
                          <select name="input[]" id="input" class="input" style="width:161px; border: 1px solid">
                            <option value="0">None</option>
                            <option value="1">Input</option>
                          </select>
                        </td>
                        <td style="padding: 5px">
                          <div id="displayInput"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Default Value
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="defaultValue[]" id="defaultValue" class="defaultValue" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayDefaultValue"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Unit
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="unit[]" id="unit" class="unit" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayUnit"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Calculation Value
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="calculationValue[]" id="calculationValue" class="calculationValue" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayCalculationValue"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Calculation Unit
                        </td>
                        <td style="padding: 5px">
                          <input type="text" autocomplete="off" name="calculationUnit[]" id="calculationUnit" class="calculationUnit" style="border: 1px solid">
                        </td>
                        <td style="padding: 5px">
                          <div id="displayCalculationUnit"></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 5px">
                          Range Value
                        </td>
                        <td style="padding: 5px">
                          <textarea name="rangeValue[]" cols="15" style="width: 161px; border: 1px solid" id="rangeValue" class="rangeValue" style="border: 1px solid"></textarea>
                        </td>
                        <td style="padding: 5px">
                          <div id="displayRangValue"></div>
                        </td>
                      </tr>
                    </table>
                    <input type="submit" value="Submit">
                  </form>
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