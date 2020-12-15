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
	margin-top:100px;
}
</style>
<style media="print">
.btn{
	display:none;
}
</style>
<title>Urine Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d', $mktime);
	$time = date('H:i:s', $mktime);
	
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

    $epithelialCells = $_POST['epithelialCells'].$_POST['epithelialCellsHPF'];
    $plusCells = $_POST['plusCells'].$_POST['plusCellsHPF'];
	
	$mysqli->query("update urine set colour = '$_POST[colour]', quantity = '$_POST[quantity]', appearance = '$_POST[appearance]', sediment = '$_POST[sediment]', reaction = '$_POST[reaction]', albumin = '$_POST[albumin]', sugar = '$_POST[sugar]', excessPhosphate = '$_POST[excessPhosphate]', bileSalt = '$_POST[bileSalt]', bilePigment = '$_POST[bilePigment]', urobilinogen = '$_POST[urobilinogen]', ketoneBodies = '$_POST[ketoneBodies]', benceJonesProtein = '$_POST[benceJonesProtein]', epithelialCells = '$epithelialCells', plusCells = '$plusCells', rbc1 = '$_POST[rbc1]', rbc2 = '$_POST[rbc2]', wbc = '$_POST[wbc]', epithelial = '$_POST[epithelial]', granular = '$_POST[granular]', hyaline = '$_POST[hyaline]', calOxalate = '$_POST[calOxalate]', amorPhos = '$_POST[amorPhos]', triplePhos = '$_POST[triplePhos]', sulphonamide = '$_POST[sulphonamide]', sricAcid = '$_POST[sricAcid]', urates = '$_POST[urates]', parasites = '$_POST[parasites]', spermatozoa = '$_POST[spermatozoa]', trichomonas = '$_POST[trichomonas]', yeast = '$_POST[yeast]', note = '$_POST[note]' where idNo = '$_POST[idNo]'") or die($mysqli->error);
	
	
	//if($addResult){
		$getResult = $mysqli->query("select * from urine join invoice on urine.idNo = invoice.idNo where urine.idNo = '$_POST[idNo]'");
		$metaArray = $getResult->fetch_array();
		?>
        <div class="btn" align="center"><button onclick="window.print()" style="padding:3px 15px; font-weight:bold">Print</button><button onclick="window.location='urine_report.php?active=urine'" style="padding:3px 15px; font-weight:bold">Back</button></div>
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
			<td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Nature of Specimen : Urine</td>
		</tr>
		
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="2" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
            <br />
                URINE EXAMINATION REPORT
            </td>
        </tr>
        <tr>
        	<td width="50%" valign="top">
            	<table cellspacing="0" width="100%">
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; padding-top:10px;">
                        PHYSICAL EXAMINATION
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="colour">Colour</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['colour']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="quantity">Quantity</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['quantity']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="appearance">Appearance</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['appearance']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sediment">Sediment</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['sediment']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; padding-top:10px;">
                        CHEMICAL EXAMINATION
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="reaction">Reaction</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['reaction']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="albumin">Albumin</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['albumin']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sugar">Sugar(Reducing Substance)</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['sugar']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="excessPhosphate">Excess Phosphate</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['excessPhosphate']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; padding-top:10px;">
                        DONE ON REQUEST ONLY
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="bileSalt">Bile Salt</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['bileSalt']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="bilePigment">Bile Pigment</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['bilePigment']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="urobilinogen">Urobilinogen</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['urobilinogen']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="ketoneBodies">Ketone Bodies</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['ketoneBodies']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="benceJonesProtein">Bence Jones Protein</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['benceJonesProtein']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="note">Note</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['note']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                </table>
            </td>
            <td width="50%" valign="top">
            	<table cellspacing="0" width="100%">
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; padding-top:10px;">
                        MICROSCOPIC EXAMINATION
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic">
                        Cells/HPF
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="epithelialCells">Epithelial Cells</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['epithelialCells']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="plusCells">Pus Cells</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['plusCells']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="rbc1">RBC</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['rbc1']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic; padding-top:10px;">
                        Casts
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="rbc2">RBC</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['rbc2']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="wbc">WBC</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['wbc']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="epithelial">Epithelial</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['epithelial']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="granular">Granular</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['granular']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="hyaline">Hyaline</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['hyaline']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic; padding-top:10px;">
                        Crystals
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="calOxalate">Cal. Oxalate</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['calOxalate']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="amorPhos">Amor. Phos</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['amorPhos']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="triplePhos">Triple Phos</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['triplePhos']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sulphonamide">Sulphonamide</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['sulphonamide']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sricAcid">Uric Acid</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['sricAcid']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sricAcid">Urates</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['urates']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="sricAcid">Parasites</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['parasites']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="spermatozoa" style="font-style:italic">Spermatozoa</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['spermatozoa']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="trichomonas" style="font-style:italic">Trichomonas</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['trichomonas']; ?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="40%"><label class="control-label" for="yeast" style="font-style:italic">Yeast</label></td>
                            <td width="2%" style="font-weight:bold">:</td>
                            <td><?php echo $metaArray['yeast']; ?></td>
                        </tr>
                        </table>
                    </td>
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