<?php 
if(isset($_GET['folder']) && isset($_GET['file'])){
	readfile($_GET['folder'] . "/" . $_GET['file']);
	// $echocontent = file_get_contents();
	// echo $echocontent;
}
?>
