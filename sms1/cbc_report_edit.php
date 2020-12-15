<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
require_once('include/header.php');
require_once('connect.php');
?>
<script src="js/bootstrap.js"></script>
<script>

$(function(){

    $('#idNo').typeahead({
        source:function(query, process){
            $.getJSON('search_id_no.php?query='+query, function(data){
                process(data);
            })
        },
        updater:function(item){
            document.location='cbc.php?active=cbc&idNo='+item;
        }
    });
});

function valid(){
	//document.getElementsByName('header[]').disabled = false;	
}
</script>      
<style>
body{
	color:#000;
}
.form-control{
	color:#000;
	border:1px solid;
}
.control-label{
	color:#000;
	font-weight:bold;
	cursor:pointer;
}
.control-label:hover{
	color:#00C;
}
.category{
	background:#666;
	padding:5px 0px;
	color:#FFF;
	font-weight:bold
}
.result-field{
	border:1px solid;
	padding:0px;
}
#box{
	margin-bottom:2px;
}
.select-control{
    padding: 6px 10px;
    border:1px solid #999;
    color: #000;
    width: 29%;
    -webkit-transition: .3s;
    -moz-transition: .3s;
    -o-transition: .3s;
    transition: .3s;
}
</style>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
        <div class="row">
        	<div class="col-lg-4 col-lg-offset-3">
            	<input autoComplete="off" type="text" class="input-control" id="idNo" name="idNo" placeholder="ID No" autoFocus>
            </div>
        </div>     
		
            <?php
			
			if(isset($_GET['idNo']) && $_GET['idNo'] <> ''){
			
				$query = $mysqli->query("select * from cbc join invoice on cbc.idNo = invoice.idNo where cbc.idNo = '$_GET[idNo]'");			
				
				if($query->num_rows > 0){
					
					$array = $query->fetch_array();
					
					$getCO = $mysqli->query("select * from co where coId = '$array[coId]'");
					$coArray = $getCO->fetch_array();
					
					$getRefd = $mysqli->query("select * from doctor where id = '$array[refdId]'");
					$refdArray = $getRefd->fetch_array();
					
				?>
                <div class="row">
                	<div class="col-lg-5">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Refd. Prof./Dr./C/O Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Refd By</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['doctor_name']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">C/O</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $coArray['coName']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Lab Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Patient SL</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['labDailySl']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">ID</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['idNo']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Patient Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                	<td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">Patient Name</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientName']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Contact</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientMobile']; ?></td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Age</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientAge']; ?>y</td>
                                </tr>
                                <tr>
                                	<td style="padding:2px 3px; border-bottom:1px solid #999">Sex</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientSex']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
                <form action="edit_cbc_result.php" method="post">
                <input autoComplete="off" type="hidden" value="<?php echo $array['idNo']; ?>" name="idNo" />
                <div class="row">
                	<div class="col-lg-12" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
                    	CBC EXAMINATION REPORT
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-6">
                    	
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
		                        	<td width="24%" style="border-bottom:1px solid; padding:5px">Haemoglobin</td>
		                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
		                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="haemoglobin" value="<?php echo $array['haemoglobin']; ?>" style="border:1px solid" onFocus="this.select()" /></td>
		                            <td colspan="2" width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
		                        </tr>
		                        <tr>
		                        	<td width="24%" style="border-bottom:1px solid; padding:5px">ESR</td>
		                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
		                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="esr" value="<?php echo $array['esr']; ?>" style="border:1px solid" onFocus="this.select()" /></td>
		                            <td colspan="2" width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
		                        </tr>
                        
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	Total Counts
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="wbc">WBC</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['wbc']; ?>" id="wbc" name="wbc" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="platelets">Platelets</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['platelets']; ?>" id="platelets" name="platelets" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="rbc">RBC</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['rbc']; ?>" id="rbc" name="rbc" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="reticulocyte">Reticulocyte</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['reticulocyte']; ?>" id="reticulocyte" name="reticulocyte" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="cirEosinophil">Cir Eosinophil</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['cirEosinophil']; ?>" id="cirEosinophil" name="cirEosinophil" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-lg-6">
                    	 <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	Differential Counts
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="neurophils">Neurophils</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['neurophils']; ?>" id="neurophils" name="neurophils" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="lymphocytes">Lymphocytes</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['lymphocytes']; ?>" id="lymphocytes" name="lymphocytes" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="eosinophils">Eosinophils</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['eosinophils']; ?>" id="eosinophils" name="eosinophils" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="basophils">Basophils</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['basophils']; ?>" id="basophils" name="basophils" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%" valign="top"><label class="control-label" for="atypicalCells">Atypical Cells</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['atypicalCells']; ?>" id="atypicalCells" name="atypicalCells" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="blastCells">Blast Cells</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['blastCells']; ?>" id="blastCells" name="blastCells" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="proMylocyte">Pro-Mylocyte</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['proMylocyte']; ?>" id="proMylocyte" name="proMylocyte" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="myetocyte">Myetocyte</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['myetocyte']; ?>" id="myetocyte" name="myetocyte" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="metaMylocyte">Meta Mylocyte</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['metaMylocyte']; ?>" id="metaMylocyte" name="metaMylocyte" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="bandForm">Band Form</label></td>
                                    <td><input autoComplete="off" type="text" value="<?php echo $array['bandForm']; ?>" id="bandForm" name="bandForm" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                	<div class="col-lg-12" align="center">
                	<button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                </form>
                <?php
				}else{
					echo "<center><font color='#FF0000' size='+1'><b>Data Not Found</b></center>";	
				}
			}
				?>
        </div>
        </div>
            </div>	       
        </div> 
        
             

      	</section>

<?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>