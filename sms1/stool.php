<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
require_once('include/header.php');
require_once('connect.php');
?>

<script>
$(function(){
    $('#idNo').typeahead({
        source:function(query, process){
            $.getJSON('search_id_no.php?query='+query, function(data){
                process(data);
            })
        },
        updater:function(item){
            document.location='stool.php?active=stool&idNo='+item;
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
</style>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper"> 
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
        	<div class="col-lg-4 col-lg-offset-3">
            	<input autoComplete="off" type="text" class="input-control" id="idNo" name="idNo" placeholder="ID No" autoFocus>
            </div>
        </div>     
		
            <?php
			
			if(isset($_GET['idNo']) && $_GET['idNo'] <> ''){
			
				$query = $mysqli->query("select * from invoice where idNo = '$_GET[idNo]'");			
				
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
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientAge']; ?></td>
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
                <form action="add_stool_result.php" method="post">
                <input autoComplete="off" type="hidden" value="<?php echo $array['idNo']; ?>" name="idNo" />
                <div class="row">
                	<div class="col-lg-12" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
                    	STOOL EXAMINATION REPORT
                    </div>
                </div>
                <br>
                <div class="row">
                	<div class="col-lg-12">
                    	<table border="0" width="100%">
                        <tr>
                        	<td width="24%" style="border-bottom:1px solid; padding:5px">Consistency</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="consistency" value="Semiformed" style="border:1px solid" onFocus="this.select()" /></td>
                            <td colspan="2" width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                        	<td width="24%" style="border-bottom:1px solid; padding:5px">Colour</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="colour" value="Brown" style="border:1px solid" onFocus="this.select()" /></td>
                            <td colspan="2" width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                        	<td width="24%" style="border-bottom:1px solid; padding:5px">Mucus</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td colspan="2" width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="mucus" value="Trace" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                        	<td width="50%" colspan="3" style="padding:5px; font-size:18px"><u>MICROSCOPIC EXAMINATION</u></td>
                            <td width="50%" colspan="2" style="padding:5px; font-size:18px"><u>DONE ON REQUEST ONLY</u></td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Protozoa</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="protozoa" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Cysts</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="cysts" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">
                            	<table border="0" width="60%">
                                <tr>
                                	<td width="49%" style="padding:0px 5px">Reducing Substance</td>
                                    <td width="1%" style="">:</td>
                                    <td width="50%" style="padding:0px 5px"><input type="text" name="reducing_substance" value="Not Done" style="border:1px solid" onFocus="this.select()" /></td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Ova</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="ova" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">
                            <table border="0" width="60%">
                            <tr>
                                <td width="49%" style="padding:0px 5px">Occult Blood Test</td>
                                <td width="1%" style="">:</td>
                                <td width="50%" style="padding:0px 5px"><input type="text" name="occult_blood_test" value="Not Done" style="border:1px solid" onFocus="this.select()" /></td>
                            </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Larva</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="larva" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">
                            <table border="0" width="60%">
                            <tr>
                                <td width="49%" style="padding:0px 5px">Total Ova Count</td>
                                <td width="1%" style="">:</td>
                                <td width="50%" style="padding:0px 5px"><input type="text" name="total_ova_count" value="Not Done" style="border:1px solid" onFocus="this.select()" /></td>
                            </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Pus Cell</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="pus_cell" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">RBC</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="rbc" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Macrophage</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="macrophage" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Fat Globules</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="fat_globules" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Vegetable Cells</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="vegetable_cells" value="A few" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="24%" style="border-bottom:1px solid; padding:5px">Candida</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="25%" style="border-bottom:1px solid; padding:5px"><input type="text" name="candida" value="Nil" style="border:1px solid" onFocus="this.select()" /></td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
                        </tr>
                        </table>
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