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
            document.location='semen.php?active=semen&idNo='+item;
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
                <form action="add_semen_result.php" method="post">
                <input autoComplete="off" type="hidden" value="<?php echo $array['idNo']; ?>" name="idNo" />
                <div class="row">
                	<div class="col-lg-12" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
                    	SEMEN ANALYSIS REPORT
                    </div>
                </div>
                <br>
                <div class="row">
                	<div class="col-lg-12">
                    	<table border="0" width="100%">
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">1. Volume</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px">About <input type="text" style="border:1px solid" name="volume" onFocus="this.select()"> ml</td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">2. Colour</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px"><input type="text" style="border:1px solid" name="colour" value="Dirty White" onFocus="this.select()"></td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:5px; font-weight:bold">3. Liquefacation</td>
                            <td width="1%" style="padding:5px">:</td>
                            <td width="50%" style="padding:5px"><input type="text" style="border:1px solid" name="liquefacation" value="Comepletely liquefied" onFocus="this.select()"></td>
                        </tr>
                        <tr>
                        	<td colspan="3" style="border-bottom:1px solid" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(After Incubation at 37&mu; Celcius for 30 Minutes)</td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">4. pH</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px"><input type="text" style="border:1px solid" name="ph" value="Alkaline" onFocus="this.select()"></td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:5px; font-weight:bold">5. Sperm Count</td>
                            <td width="1%" style="padding:5px">:</td>
                            <td width="50%" style="padding:5px"><input type="text" style="border:1px solid" name="sperm_count" value="" onFocus="this.select()"> Millions/ml</td>
                        </tr>
                        <tr>
                        	<td colspan="2" style="border-bottom:1px solid"></td>
                        	<td style="border-bottom:1px solid" align="left">Normal Value: 20-120 Millions/ml</td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:0px 5px; font-weight:bold">6. Sperm Motility</td>
                            <td width="1%" style="padding:0px 5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Actively Motile
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="actively_motility" value="" onFocus="this.select()"> %
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:0px 5px; font-weight:bold">(Motility within One Hour of Ejaculation)</td>
                            <td width="1%" style="padding:0px 5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Feebly Motile
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="feebly_motility" value="" onFocus="this.select()"> %
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">&nbsp;</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="padding:0px 5px; border-bottom:1px solid; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Non Motile
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="non_motility" value="" onFocus="this.select()"> %
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:0px 5px; font-weight:bold">7. Sperm Morphology</td>
                            <td width="1%" style="padding:0px 5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Normal
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="s_m_normal" value="" onFocus="this.select()"> %
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:5px; font-weight:bold">&nbsp;</td>
                            <td width="1%" style="padding:5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Abnormal
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="s_m_abnormal" value="" onFocus="this.select()"> %
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3" style="border-bottom:1px solid" align="left">(Normal semen should contain at least 50% of spermatozoa with normal morphology)</td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:0px 5px; font-weight:bold">8. Others Cells</td>
                            <td width="1%" style="padding:0px 5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Pus Cells
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="pus_cells" value="" onFocus="this.select()"> /HPF
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="padding:0px 5px; font-weight:bold">&nbsp;</td>
                            <td width="1%" style="padding:0px 5px">:</td>
                            <td width="50%" style="padding:0px 5px; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	Epithelial Cells
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="epithelial_cells" value="" onFocus="this.select()"> /HPF
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">&nbsp;</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="padding:0px 5px; border-bottom:1px solid; padding-top:3px">
                            	<table border="0" width="100%">
                                <tr>
                                <td width="25%">
                            	RBC
                                </td>
                                <td> : <input type="text" style="border:1px solid" name="rbc" value="Absent" onFocus="this.select()"> /HPF
                                </td>
                               	</tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">9. Sperm Viability</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px"><input type="text" style="border:1px solid" name="sperm_viability" onFocus="this.select()" value="Not done"></td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">10. Sperm Clumping</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px"><input type="text" style="border:1px solid" name="sperm_clumping" onFocus="this.select()" value="Absent"></td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">11. Fructose Test</td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">:</td>
                            <td width="50%" style="border-bottom:1px solid; padding:5px"><input type="text" style="border:1px solid" name="fructose_test" onFocus="this.select()" value="Not done"></td>
                        </tr>
                        <tr>
                        	<td width="49%" style="border-bottom:1px solid; padding:5px; font-weight:bold">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="49%">Opinion</td>
                                    <td width="1%">:</td>
                                    <td width="50%" style="padding:5px"><input type="text" style="border:1px solid" name="opinion" onFocus="this.select()" value="Oligospermia"></td>
                                </tr>
                                <tr valign="top">
                                	<td width="49%">Advice</td>
                                    <td width="1%">:</td>
                                    <td width="50%" style="padding:5px"><textarea name="advice" style="border:1px solid"></textarea></td>
                                </tr>
                                </table>
                            </td>
                            <td width="1%" style="border-bottom:1px solid; padding:5px">&nbsp;</td>
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