  <div class="clearfix"></div>
  <footer>
		<div class="container-fluid panel-white">
    
                   
			<p class="copyright">&copy; 2020 <a href="#" target="_blank"><?php
                  $labsql = "SELECT * FROM lab_info WHERE id=1";
                  $result = $mysqli->query($labsql); 
              /*    while ($row = $result->fetch_assoc()) {
                    echo $row['lab_name'];
                    }*/
                ?></a>. Dr.Lad's Nath Pathology All Rights Reserved.</p>
		</div>
   </footer>
</div>
 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>

<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>

<script src="assets/scripts/klorofil-common.js"></script>
<link href="css/jquery.datepick.css" rel="stylesheet">
    <script src="js/jquery.plugin.js"></script>
    <script src="js/jquery.datepick.js"></script>
    
    <script src="js/jquery.customSelect.min.js" ></script>
    <script>
        $(document).ready(function() {
			$('#from_date').datepick();
			$('#to_date').datepick();
		/*	$('#inlineDatepicker').datepick({onSelect: showDate});*/
        });
    </script>