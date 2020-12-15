<?php

require_once('connect.php');

$reportId = $_POST['reportId'];
$fieldName = $_POST['fieldName'];
$values = $_POST['values'];

$query = $mysqli->query("update report set $fieldName = '$values' where reportId = $reportId");

?>