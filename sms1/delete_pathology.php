<?php
ob_start();
@session_start();
require_once('connect.php');

$delete = $mysqli->query("delete from pathology where pathologyId = '$_GET[pathologyId]'");

$delete = $mysqli->query("delete from pathology_header_meta where pathologyHeaderMetaId = '$_GET[pathologyHeaderMetaId]' and pathologyId = '$_GET[pathologyId]'");

$delete = $mysqli->query("delete from pathology_meta where pathologyMetaId = '$_GET[pathologyMetaId]' and pathologyId = '$_GET[pathologyId]'");

if($delete){
	header("Location:pathology_details.php?active=pathology_details&delete=success");	
}

?>