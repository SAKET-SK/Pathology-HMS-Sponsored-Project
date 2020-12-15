<?php require_once('connect.php'); ?>

<?php 
    date_default_timezone_set('UTC');
	$mkdate = mktime(date('H') + 6, date('i'), date('s'));
	$date = date('Y-m-d', $mkdate);
	$time = date('h:i:s', $mkdate);
	$labels = array();
	$series = array();
	
	$day=0;
	while ($day <= 5) {
		$newdate = strtotime("-1 day", strtotime($date));
		$query= $mysqli->query("select sum(patientPayAmount) As sum, patientPayDate from patient_payment where patientPayDate='$newdate'");
		$row = $query->fetch_assoc();
		$arraydate=  date('d/m/y', strtotime($row['patientPayDate']));
		    array_push($labels, $arraydate);
		    array_push($series, $row['sum']);
	}
	
	/*$query= $mysqli->query("select sum(patientPayAmount) As sum, patientPayDate from patient_payment  group by patientPayDate desc limit 5");
		 //print_r($query);
		//$query= $mysqli->query("select count(invoiceId) As count, invoiceDate from invoice  group by invoiceDate desc limit 7");
		
		$labels = array();
		$series = array();
		while ($row = $query->fetch_assoc()) {
		    $arraydate=  date('d/m/y', strtotime($row['patientPayDate']));
		    array_push($labels, $arraydate);
		    array_push($series, $row['sum']);
		}*/
?>
<div class="col-md-4">
					<!-- RECENT PURCHASES -->
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">Recent 5 day's Payment</h4>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body no-padding">
	
	
				<div id="demo-bar-chart" class="ct-chart"></div>
				
				</div>
						
					</div>
					<!-- END RECENT PURCHASES -->
				</div>
				
	
	
				
<script>
	$(function() {
		var options;

		var data = {
			labels: <?php echo json_encode($labels); ?>  ,
			series: [
				<?php echo json_encode($series); ?> ,
			]
		};
		options = {
			height: "320px",
			axisX: {
				showGrid: false
			},
			plugins: [
    Chartist.plugins.ctAxisTitle({
      axisX: {
        axisTitle: '----Date----',
        axisClass: 'ct-axis-title',
        offset: {
          x: 0,
          y: 30
        },
        textAnchor: 'middle'
      },
      axisY: {
        axisTitle: 'Amount (৳)',
        axisClass: 'ct-axis-title',
        offset: {
          x: 0,
          y: -8
        },
        textAnchor: 'middle',
        flipTitle: false
      }
    })
  ]
		};

		new Chartist.Bar('#demo-bar-chart', data, options);
	});
</script>



	
