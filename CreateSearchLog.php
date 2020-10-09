<?php
if (isset($_POST['getUrl'])){	
	$url = $_POST['getUrl'];
	$txt = $url.",".date("d-m-Y H:i:s");
	$myfile = file_put_contents('SearchTracker.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	echo true;
}
?>