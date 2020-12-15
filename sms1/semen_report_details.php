<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
require_once('connect.php');
?>

<style>
#result{
	width:700px;
	min-height:200px;
	height:auto;
	margin:auto;
}
#main_page{
	width:700px;
	height:auto;
	margin:auto;
	margin-top:130px;
}
</style>
<style media="print">
.btn{
	display:none;
}
</style>
<title>Semen Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d', $mktime);
	$time = date('H:i:s', $mktime);
	
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
	
	//if($addResult){
		$getResult = $mysqli->query("select * from semen join invoice on semen.idNo = invoice.idNo where semen.idNo = '$_GET[idNo]'");
		$metaArray = $getResult->fetch_array();
		?>
        <div class="btn" align="center"><button onclick="window.print()" style="padding:3px 15px; font-weight:bold">Print</button><button onclick="window.location='semen_report.php?active=urine'" style="padding:3px 15px; font-weight:bold">Back</button></div>
        <div id="main_page">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
            <td width="120px" style="font-weight:bold; border:1px solid">&nbsp;&nbsp;Lab ID NO : <?php echo $metaArray['pathDailySl']; ?></td>
            <td colspan="2" width="120px" style="font-weight:bold; border:1px solid; border-left:none; text-align:center">Date : 
            <?php
                $resultDate = new DateTime($metaArray['date']);
                echo '<i>'.$resultDate->format('M d, Y').'</i>';
                            ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;ID No : <?php echo $metaArray['idNo']; ?></td>
        </tr>
        <tr>
            <td width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Name : <?php echo $metaArray['patientName']; ?></td>
            <td width="120px" style="font-weight:bold; border:1px solid; border-left:none; border-top:none; text-align:left">&nbsp;&nbsp;Age : <?php echo $metaArray['patientAge']; ?></td>
            <td width="120px" style="font-weight:bold; border:1px solid; border-left:none; border-top:none; text-align:left">&nbsp;&nbsp;Gender : <?php echo $metaArray['patientSex']; ?></td>
        </tr>
        <tr>
            <td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Ref By : 
            <?php
                $getRefd = $mysqli->query("select * from doctor where id = '$metaArray[refdId]'");
                $refdArray = $getRefd->fetch_array();
                                    
                echo $refdArray['doctor_name'];
            ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Nature of Specimen : Semen</td>
        </tr>
        
        </table>
        <table width="100%" border="0">
        <tr>
            <td align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
            <br />
                SEMEN ANALYSIS REPORT
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
            	<table border="0" width="100%">
                <tr>
                    <td width="49%" style="padding:5px">1. Volume</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px">About <?php echo $metaArray['volume']; ?> ml</td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">2. Colour</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['colour']; ?></td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">3. Liquefacation</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['liquefacation']; ?></td>
                </tr>
                <tr>
                    <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(After Incubation at 37&mu; Celcius for 30 Minutes)</td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">4. pH</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['ph']; ?></td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">5. Sperm Count</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['sperm_count']; ?> Millions/ml</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td align="left">Normal Value: 20-120 Millions/ml</td>
                </tr>
                <tr>
                    <td width="49%" style="padding:0px 5px; padding-top:5px">6. Sperm Motility</td>
                    <td width="1%" style="padding:0px 5px; padding-top:5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:5px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Actively Motile
                        </td>
                        <td> : <?php echo $metaArray['actively_motility']; ?> %
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:0px 5px">(Motility within One Hour of Ejaculation)</td>
                    <td width="1%" style="padding:0px 5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Feebly Motile
                        </td>
                        <td> : <?php echo $metaArray['feebly_motility']; ?> %
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">&nbsp;</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Non Motile
                        </td>
                        <td> : <?php echo $metaArray['non_motility']; ?> %
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:0px 5px">7. Sperm Morphology</td>
                    <td width="1%" style="padding:0px 5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Normal
                        </td>
                        <td> : <?php echo $metaArray['s_m_normal']; ?> %
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">&nbsp;</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Abnormal
                        </td>
                        <td> : <?php echo $metaArray['s_m_abnormal']; ?> %
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left">(Normal semen should contain at least 50% of spermatozoa with normal morphology)</td>
                </tr>
                <tr>
                    <td width="49%" style="padding:0px 5px">8. Others Cells</td>
                    <td width="1%" style="padding:0px 5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Pus Cells
                        </td>
                        <td> : <?php echo $metaArray['pus_cells']; ?> /HPF
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:0px 5px">&nbsp;</td>
                    <td width="1%" style="padding:0px 5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        Epithelial Cells
                        </td>
                        <td> : <?php echo $metaArray['epithelial_cells']; ?> /HPF
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">&nbsp;</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:0px 5px; padding-top:3px">
                        <table border="0" width="100%">
                        <tr>
                        <td width="35%">
                        RBC
                        </td>
                        <td> : <?php echo $metaArray['rbc']; ?> /HPF
                        </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">9. Sperm Viability</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['sperm_viability']; ?></td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">10. Sperm Clumping</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['sperm_clumping']; ?></td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">11. Fructose Test</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="50%" style="padding:5px"><?php echo $metaArray['fructose_test']; ?></td>
                </tr>
                <tr>
                    <td width="49%" style="padding:5px">
                        <table border="0" width="100%">
                        <tr>
                            <td width="49%">Opinion</td>
                            <td width="1%">:</td>
                            <td width="50%" style="padding:5px"><?php echo $metaArray['opinion']; ?></td>
                        </tr>
                        <tr valign="top">
                            <td width="49%">Advice</td>
                            <td width="1%">:</td>
                            <td width="50%" style="padding:5px"><?php echo $metaArray['advice']; ?></td>
                        </tr>
                        </table>
                    </td>
                    <td width="1%" style="padding:5px">&nbsp;</td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
        </div>
        <?php
		
	//}
	
}else{
	header("Location:index.php");	
}
?>