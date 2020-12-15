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
            document.location='urine.php?active=urine&idNo='+item;
        }
    });

	$('#colour').typeahead({
		source: ['Nil', 'Straw', 'High', 'Reddish']
	});
	$('#appearance').typeahead({
		source: ['Nil', 'Clear', 'Hazy', 'Smoky']
	});
	$('#sediment').typeahead({
		source: ['Nil', 'Absent', 'Absent(+)', 'Absent(++)', 'Absent(+++)', 'Present(+)', 'Present(++)', 'Present(+++)']
	});
	$('#reaction').typeahead({
		source: ['Nil', 'Acidic']
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
                <form action="add_urine_result.php" method="post">
                <input autoComplete="off" type="hidden" value="<?php echo $array['idNo']; ?>" name="idNo" />
                <div class="row">
                	<div class="col-lg-12" align="center" style="font-size:20px; font-weight:bold; text-decoration:underline">
                    	URINE EXAMINATION REPORT
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-6">
                    	<div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	PHYSICAL EXAMINATION
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="colour">Colour</label></td>
                                    <td><input autoComplete="off" type="text" value="Straw" id="colour" name="colour" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                            <div class="col-lg-12">
                                <table border="0" width="100%">
                                <tr>
                                    <td width="40%"><label class="control-label" for="quantity">Quantity</label></td>
                                    <td><input autoComplete="off" type="text" value="Sufficient" id="quantity" name="quantity" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="appearance">Appearance</label></td>
                                    <td><input autoComplete="off" type="text" value="Clear" id="appearance" name="appearance" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="sediment">Sediment</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="sediment" name="sediment" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	CHEMICAL EXAMINATION
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="reaction">Reaction</label></td>
                                    <td><input autoComplete="off" type="text" value="Acidic" id="reaction" name="reaction" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="albumin">Albumin</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="albumin" name="albumin" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="sugar">Sugar(Reducing Substance)</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="sugar" name="sugar" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="excessPhosphate">Excess Phosphate</label></td>
                                    <td><input autoComplete="off" type="text" value="Absent" id="excessPhosphate" name="excessPhosphate" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	DONE ON REQUEST ONLY
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="bileSalt">Bile Salt</label></td>
                                    <td><input autoComplete="off" type="text" value="Not Done" id="bileSalt" name="bileSalt" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="bilePigment">Bile Pigment</label></td>
                                    <td><input autoComplete="off" type="text" value="Not Done" id="bilePigment" name="bilePigment" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="urobilinogen">Urobilinogen</label></td>
                                    <td><input autoComplete="off" type="text" value="Not Done" id="urobilinogen" name="urobilinogen" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="ketoneBodies">Ketone Bodies</label></td>
                                    <td><input autoComplete="off" type="text" value="Not Done" id="ketoneBodies" name="ketoneBodies" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="benceJonesProtein">Bence Jones Protein</label></td>
                                    <td><input autoComplete="off" type="text" value="Not Done" id="benceJonesProtein" name="benceJonesProtein" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%" valign="top"><label class="control-label" for="note">Note</label></td>
                                    <td><textarea id="note" name="note" class="input-control" onFocus="this.select()"></textarea></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    	<div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold">
                            	MICROSCOPIC EXAMINATION
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic">
                            	Cells/HPF
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="epithelialCells">Epithelial Cells</label></td>
                                    <td><input autoComplete="off" type="text" value="0-2" id="epithelialCells" name="epithelialCells" style="width: 70%;" class="input-control" onFocus="this.select()">
                                        <select class="select-control" name="epithelialCellsHPF">
                                            <option value="/HPF">HPF</option>
                                            <option value="">None</option>
                                        </select>
                                    </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="plusCells">Pus Cells</label></td>
                                    <td><input autoComplete="off" type="text" value="0-2" id="plusCells" name="plusCells" class="input-control" style="width: 70%;" onFocus="this.select()">
                                        <select class="select-control" name="plusCellsHPF">
                                            <option value="/HPF">HPF</option>
                                            <option value="">None</option>
                                        </select>
                                    </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="rbc1">RBC</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="rbc1" name="rbc1" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic">
                            	Casts
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="rbc2">RBC</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="rbc2" name="rbc2" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="wbc">WBC</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="wbc" name="wbc" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="epithelial">Epithelial</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="epithelial" name="epithelial" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="granular">Granular</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="granular" name="granular" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="hyaline">Hyaline</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="hyaline" name="hyaline" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-12" style="font-size:16px; text-decoration:underline; font-weight:bold; font-style:italic">
                            	Crystals
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="calOxalate">Cal. Oxalate</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="calOxalate" name="calOxalate" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="amorPhos">Amor. Phos</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="amorPhos" name="amorPhos" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="triplePhos">Triple Phos</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="triplePhos" name="triplePhos" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="sulphonamide">Sulphonamide</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="sulphonamide" name="sulphonamide" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="sricAcid">Uric Acid</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="sricAcid" name="sricAcid" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                            <div class="col-lg-12">
                                <table border="0" width="100%">
                                <tr>
                                    <td width="40%"><label class="control-label" for="urates">Urates</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="urates" name="urates" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                            <div class="col-lg-12">
                                <table border="0" width="100%">
                                <tr>
                                    <td width="40%"><label class="control-label" for="parasites">Parasites</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="parasites" name="parasites" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
	                        <div class="col-lg-12">
                        	&nbsp;
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="spermatozoa" style="font-style:italic">Spermatozoa</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="spermatozoa" name="spermatozoa" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="trichomonas" style="font-style:italic">Trichomonas</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="trichomonas" name="trichomonas" class="input-control" onFocus="this.select()"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="box">
                        	<div class="col-lg-12">
                            	<table border="0" width="100%">
                                <tr>
                                	<td width="40%"><label class="control-label" for="yeast" style="font-style:italic">Yeast</label></td>
                                    <td><input autoComplete="off" type="text" value="Nil" id="yeast" name="yeast" class="input-control" onFocus="this.select()"></td>
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