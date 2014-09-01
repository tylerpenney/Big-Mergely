<?php 
$filecontents = $_POST['filecontents'];
$file = $_POST['filed'];
if($file != '' && $filecontents != ''){
	$filel = 'new_custom/' . $file;
	file_put_contents($filel, $filecontents);
	echo 'done';
}
?>
