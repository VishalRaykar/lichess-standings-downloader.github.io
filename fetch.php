<?php
if (isset($_POST['getUrl'])){	
	$url = $_POST['getUrl'];
	$response =  file_get_contents($url);
	echo $response;
}
?>