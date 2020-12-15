<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('connect.php');


	$query = $mysqli->query("select * from tests where testCategoryId = '$_POST[categoryId]'");
	
	if($query->num_rows > 0){
	?>
    	<option value="">--Select One--</option>
    <?php		
		while($rows = $query->fetch_array()){
		?>
        	<option value="<?php echo $rows['testId']; ?>"><?php echo $rows['testName']; ?></option>
		<?php	
		}
	}else{
		?>
            <option value="">--Select One--</option>
        <?php
	}

}else{
	header("Location:index.php");	
}
?>