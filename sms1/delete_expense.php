<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
	require_once('include/header.php');
	require_once('connect.php');


$get_id=$_GET['id'];
$query = $mysqli->query("delete from expense_details where Id='$get_id'");

}?>

<script type="text/javascript">
        alert("Deleted successfully");
          window.location= "expense_list.php?active=expense_list";
</script>