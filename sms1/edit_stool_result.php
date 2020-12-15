<?php
ob_start();
@session_start();
if(isset($_SESSION['userId'])){
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
<title>Pathology Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d', $mktime);
	$time = date('H:i:s', $mktime);
	
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
	$mysqli->query("update stool set consistency='$_POST[consistency]', colour='$_POST[colour]', mucus='$_POST[mucus]', protozoa='$_POST[protozoa]', cysts='$_POST[cysts]', reducing_substance='$_POST[reducing_substance]', ova='$_POST[ova]', occult_blood_test='$_POST[occult_blood_test]', larva='$_POST[larva]', total_ova_count='$_POST[total_ova_count]', pus_cell='$_POST[pus_cell]', rbc='$_POST[rbc]', macrophage='$_POST[macrophage]', fat_globules='$_POST[fat_globules]', vegetable_cells='$_POST[vegetable_cells]', candida='$_POST[candida]' where idNo = '$_POST[idNo]'") or die($mysqli->error);
	
	
	//if($addResult){
		$getResult = $mysqli->query("select * from stool join invoice on stool.idNo = invoice.idNo where stool.idNo = '$_POST[idNo]'");
		$metaArray = $getResult->fetch_array();
		?>
        <div class="btn" align="center"><button onclick="window.print()" style="padding:3px 15px; font-weight:bold">Print</button><button onclick="window.location='stool_report.php?active=stool_report'" style="padding:3px 15px; font-weight:bold">Back</button></div>
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
            <td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Nature of Specimen : Stool</td>
        </tr>
        
        </table>
        <table width="100%" border="0">
        <tr>
            <td align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
            <br />
                STOOL EXAMINATION REPORT
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
            	<table border="0" width="100%">
                <tr>
                    <td width="24%" style="padding:5px">Consistency</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['consistency'];  ?></td>
                    <td colspan="2" width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Colour</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['colour'];  ?></td>
                    <td colspan="2" width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Mucus</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td colspan="2" width="25%" style="padding:5px"><?php echo $metaArray['mucus'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="50%" colspan="3" style="padding:5px; font-size:18px"><u>MICROSCOPIC EXAMINATION</u></td>
                    <td width="50%" colspan="2" style="padding:5px; font-size:18px"><u>DONE ON REQUEST ONLY</u></td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Protozoa</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['protozoa'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Cysts</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['cysts'];  ?></td>
                    <td width="50%" style="padding:5px">
                        <table border="0" width="100%">
                        <tr>
                            <td width="49%" style="padding:0px 5px">Reducing Substance</td>
                            <td width="1%" style="">:</td>
                            <td width="50%" style="padding:0px 5px"><?php echo $metaArray['reducing_substance'];  ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Ova</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['ova'];  ?></td>
                    <td width="50%" style="padding:5px">
                    <table border="0" width="100%">
                    <tr>
                        <td width="49%" style="padding:0px 5px">Occult Blood Test</td>
                        <td width="1%" style="">:</td>
                        <td width="50%" style="padding:0px 5px"><?php echo $metaArray['occult_blood_test'];  ?></td>
                    </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Larva</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['larva'];  ?></td>
                    <td width="50%" style="padding:5px">
                    <table border="0" width="100%">
                    <tr>
                        <td width="49%" style="padding:0px 5px">Total Ova Count</td>
                        <td width="1%" style="">:</td>
                        <td width="50%" style="padding:0px 5px"><?php echo $metaArray['total_ova_count'];  ?></td>
                    </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Pus Cell</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['pus_cell'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">RBC</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['rbc'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Macrophage</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['macrophage'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Fat Globules</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['fat_globules'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Vegetable Cells</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['vegetable_cells'];  ?></td>
                    <td width="50%" style="padding:5px">&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" style="padding:5px">Candida</td>
                    <td width="1%" style="padding:5px">:</td>
                    <td width="25%" style="padding:5px"><?php echo $metaArray['candida'];  ?></td>
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