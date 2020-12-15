<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
require_once('connect.php');
?>



<section id="main-content">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <section class="wrapper">            
        <!--overview start-->
		<div class="row">
			<ol class="breadcrumb">
				<li><i class="fa fa-angle-double-right"></i><a href="index.php">&nbsp; Home</a></li>
				<li style="color:#1a1a1a;">
                <?php 
                    $active = explode("_",$_GET['active']);
							
					foreach($active as $name){
						echo ucfirst($name);
						echo " ";
					}
                    ?>
                </li>						  	
			</ol>
		</div>

		<div class="container" style="width:900px;">
   			<h3 align="center">Last 7 Days Services</h3>   
   			<br /><br />
   			<div id="chart"></div>
  		</div>

		<?php
		date_default_timezone_set('UTC');
		$mkdate = mktime(date('H') + 6, date('i'), date('s'));
		$date = date('Y-m-d', $mkdate);
		//$time = date('h:i:s', $mkdate);
		$day=0;
		while ($day <= 7) {
			$date = date('Y-m-d', strtotime("-$day days"));
			$query = $mysqli->query("select * from invoice invoiceDate='$date'");
			$row_cnt = $query->num_rows;

 			$chart_data .= "{ date:'".$date."', services:".$row_cnt."}, ";
		}
		?>
	</section>
</section>

<script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'date',
 ykeys:'services',
 labels:'services',
 hideHover:'auto',
 stacked:true
});
</script>

<?php
require_once('include/footer.php'); 
}else{
  header("Location:index.php"); 
}
?>