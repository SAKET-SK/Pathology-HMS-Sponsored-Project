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
<title>CBC Result</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$mktime = mktime(date("H")+6, date("i"), date("s"));
	$date = date('Y-m-d', $mktime);
	$time = date('H:i:s', $mktime);
	
	$colormetricValue=$_POST[haemoglobin];
    if ($colormetricValue==3.8) { $colormetric=21;}
    else if($colormetricValue==4){$colormetric=24;}
    else if($colormetricValue==4.3){$colormetric=26;}
    else if($colormetricValue==4.8){$colormetric=30;}
    else if($colormetricValue==5.2){ $colormetric=32;}
    else if($colormetricValue==5.6){$colormetric=35;}
    else if($colormetricValue==6){$colormetric=37;}
    else if($colormetricValue==6.5){$colormetric=40;}
    else if($colormetricValue==6.9){$colormetric=43;}
    else if($colormetricValue==7.3){$colormetric=45;}
    else if($colormetricValue==7.8){ $colormetric=48;}
    else if($colormetricValue==8.2){$colormetric=51;}
    else if($colormetricValue==8.6){$colormetric=53;}
    else if($colormetricValue==9.1){$colormetric=56;}
    else if($colormetricValue==9.5){$colormetric=60;}
    else if($colormetricValue==10){$colormetric=62;}
    else if($colormetricValue==10.2){ $colormetric=64;}
    else if($colormetricValue==10.8){$colormetric=60;}
    else if($colormetricValue==11.2){$colormetric=70;}
    else if($colormetricValue==11.7){$colormetric=73;}
    else if($colormetricValue==12.1){$colormetric=75;}
    else if($colormetricValue==12.5){$colormetric=78;}
    else if($colormetricValue==13){ $colormetric=81;}
    else if($colormetricValue==13.4){$colormetric=83;}
    else {$colormetric=0;}

    
	
	$mysqli->query("update cbc set  haemoglobin='$_POST[haemoglobin]',colormetric= $colormetric, esr= '$_POST[esr]', wbc='$_POST[wbc]', platelets='$_POST[platelets]', rbc='$_POST[rbc]', reticulocyte='$_POST[reticulocyte]', cirEosinophil='$_POST[cirEosinophil]', neurophils='$_POST[neurophils]', lymphocytes='$_POST[lymphocytes]',monocytes='$_POST[monocytes]', eosinophils='$_POST[eosinophils]', basophils='$_POST[basophils]', atypicalCells='$_POST[atypicalCells]', blastCells='$_POST[blastCells]',  proMylocyte='$_POST[proMylocyte]', myetocyte='$_POST[myetocyte]', metaMylocyte='$_POST[metaMylocyte]', bandForm='$_POST[bandForm]' where idNo = '$_POST[idNo]'") or die($mysqli->error);
	
	
	//if($addResult){
		$getResult = $mysqli->query("select * from cbc join invoice on cbc.idNo = invoice.idNo where cbc.idNo = '$_POST[idNo]'");
        $metaArray = $getResult->fetch_array();
        ?>
        <div class="btn" align="center"><button onclick="window.print()" style="padding:3px 15px; font-weight:bold">Print</button><button onclick="window.location='cbc.php?active=cbc'" style="padding:3px 15px; font-weight:bold">Back</button></div>
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
            <td colspan="3" width="120px" style="font-weight:bold; border:1px solid; border-top:none;">&nbsp;&nbsp;Nature of Specimen : CBC</td>
        </tr>
        
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="margin-bottom:10px;">
            <td colspan="2" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
            <br />
                CBC EXAMINATION REPORT<br />
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <table cellspacing="0" width="100%">
                <tr style="text-align:left;">
                   <th width="40%">Test</th>
                   <th width="10%" >Result</th>
                   <th width="20%" ></th>
                   <th >Referrence Range</th>
                </tr> 
                <tr>
                     <td ><label class="control-label" for="colour" style="font-weight:bold;">Haemoglobin</label></td>               
                     <td ><?php echo $metaArray['haemoglobin']; ?> </td>
                     <td >gm/dl</td>
                     <td >Male: 12-18 gm/dl </td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour" style="font-size:11px;">(Colormetric Method)</label></td>              
                     <td ><?php echo $colormetric; ?> </td>
                     <td >%</td>
                     <td >Female: 11-16 gm/dl </td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour"  style="font-weight:bold;">ESR</label></td>              
                     <td ><?php echo $metaArray['esr']; ?></td>
                     <td> mm in 1<sup>st</sup> hour</td>
                     <td >Male: 0-10 mm </td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour" style="font-size:11px;">(Westergren Method)</label></td>              
                     <td ></td>
                     <td ></td>
                     <td >Female: 0-15 mm </td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                    <td colspan="4"  style="font-weight:bold;">Total Counts</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">WBC</label></td>               
                     <td ><?php echo $metaArray['wbc']; ?> </td>
                     <td>/mm<sup>3</sup></td>
                     <td >4000-11000/mm<sup>3</sup></td>
                </tr>
                <tr>
                     <td><label class="control-label" for="colour">Platelates</label></td>               
                     <td><?php echo $metaArray['platelets']; ?> </td>
                     <td>/mm<sup>3</sup></td>
                     <td >150000-350000/mm<sup>3</sup></td>
                </tr>
                <tr>
                     <td><label class="control-label" >RBC</label></td>               
                     <td><?php echo $metaArray['rbc']; ?> </td>
                     <td>/mm<sup>3</sup></td>
                     <td >4.5-6.6 X 10<sup>6</sup>/mm<sup>3</sup></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Reticulocyte</label></td>               
                     <td ><?php echo $metaArray['reticulocyte']; ?> </td>
                     <td>% of RBC</td>
                     <td >0.2-2% of RBC</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">CIR Eosinophil</label></td>               
                     <td ><?php echo $metaArray['cirEosinophil']; ?> </td>
                     <td>/mm<sup>3</sup></td>
                     <td >Up to 400/mm<sup>3</sup></td>
                </tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr><td colspan="4"  style="font-weight:bold;">Differential Counts</td></tr>
                <tr>
                     <td ><label class="control-label" for="colour">Neutrophils</label></td>               
                     <td ><?php echo $metaArray['neurophils']; ?> </td>
                     <td>%</td>
                     <td >40-75%</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Lymphocytes</label></td>               
                     <td ><?php echo $metaArray['lymphocytes']; ?> </td>
                     <td>%</td>
                     <td >20-50%</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Monocytes</label></td>               
                     <td ><?php echo $metaArray['monocytes']; ?> </td>
                     <td>%</td>
                     <td >2-10%</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Eosinophils</label></td>               
                     <td ><?php echo $metaArray['eosinophils']; ?> </td>
                     <td>%</td>
                     <td >1-8%</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Basophils</label></td>               
                     <td ><?php echo $metaArray['basophils']; ?> </td>
                     <td>%</td>
                     <td >0-1%</td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Atypical Cells</label></td>               
                     <td ><?php echo $metaArray['atypicalCells']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Blast Cells</label></td>               
                     <td ><?php echo $metaArray['blastCells']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Pro-Mylocyte</label></td>               
                     <td ><?php echo $metaArray['proMylocyte']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Mylocyte</label></td>               
                     <td ><?php echo $metaArray['myetocyte']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Meta Mylocyte</label></td>               
                     <td ><?php echo $metaArray['metaMylocyte']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
                <tr>
                     <td ><label class="control-label" for="colour">Band Form</label></td>               
                     <td ><?php echo $metaArray['bandForm']; ?> </td>
                     <td>%</td>
                     <td ></td>
                </tr>
            </table>
            
            
        </tr>
        </table>
        </div>
        <?php
        
    //}
    
}else{
    header("Location:index.php");   
}
?>