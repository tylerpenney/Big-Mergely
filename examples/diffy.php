<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" /><title>Diffy</title>
	<meta http-equiv="X-UA-Compatible" content="chrome=1, IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<!-- Requires jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
	
	<!-- Requires CodeMirror -->
	<script type="text/javascript" src="../lib/codemirror.js"></script>
	<link type="text/css" rel="stylesheet" href="../lib/codemirror.css" />
	
	<!-- Requires Mergely -->
	<script type="text/javascript" src="../lib/mergely.js"></script>
	<link type="text/css" rel="stylesheet" href="../lib/mergely.css" />
	
	<script type="text/javascript">

        $(document).ready(function () {
	
			<?php
			$dircust = 'custom/';
			$dirdef = 'default/';
			// get an array of all the files in both directories
			$filecust = scandir($dircust);
			$filedef = scandir($dirdef);

			// count the files in the default directory (will be same in custom)
			$count = count($filedef);
			// set up initial group array to split up files into groups of 10..
			$group = array();
			// initiate the count for the files at 0;
			$cnt = 0;
			for($i=0; $i<$count; $i++){
				// get the full path  of each file
				$fullpath = $dirdef  . $filedef[$i];
				$fullpathcust = $dircust . $filedef[$i];
				// get the file size of each file
				$custsize = filesize($fullpathcust);
				$defsize = filesize($fullpath);
				if($custsize != $defsize){ // only get files that are different file sizes (indicating a differnce in file).. 
					
				if ($filedef[$i] === '.' or $filedef[$i] === '..') continue; // only get files not . or .. 
				
				if(is_file($fullpath)){ // if the thing you are looking at is a file 
					$cnt++; // add to the total count;
					// put the files into groups of 10
					switch($cnt){
						case $cnt <= 10 :
						$group[1][] = $filedef[$i];
						break;
						case ($cnt >= 11 && $cnt <= 20):
						$group[2][] = $filedef[$i];
						break;
						case ($cnt >= 21 && $cnt <= 30):
						$group[3][] = $filedef[$i];
						break;	
						case ($cnt >= 31 && $cnt <= 40):
						$group[4][] = $filedef[$i];
						break;
						case ($cnt >= 41 && $cnt <= 50):
						$group[5][] = $filedef[$i];
						break;	
						case ($cnt >= 51 && $cnt <= 60):
						$group[6][] = $filedef[$i];
						break;
						case ($cnt >= 61 && $cnt <= 70):
						$group[7][] = $filedef[$i];
						break;
						case ($cnt >= 71 && $cnt <= 80):
						$group[8][] = $filedef[$i];
						break;				
					}
					}
				}
			}
			// you get to the correct part of the group through this GET variable 
			if(is_numeric($_GET['group'])){
				$groupGET = $_GET['group'];
			} else {
				$groupGET = 1; // default to the first group if none is selected. 
			}
			
			$groupcount = count($group[$groupGET]);
			
			for($i=0; $i<$groupcount; $i++){

					$fullpath = $dirdef  . $group[$groupGET][$i];
					$fullpathcust = $dircust . $group[$groupGET][$i];
					$get_def = "getcontent.php?folder=default&file=" . $group[$groupGET][$i];
					$get_cust = "getcontent.php?folder=custom&file=" . $group[$groupGET][$i];
					$filename = basename($fullpath, ".php");
					$filenameDIV = str_replace(".","-",$filename);
					
					?>
					$('<?php echo "#" . $filenameDIV;?>').mergely({
						width: 1260,
						height: 300,
						cmsettings: {
							readOnly: false, 
							lineWrapping: true,
						}
					});

					$.ajax({
						type: 'GET', async: true, dataType: 'text',
						// CHANGE THIS TO YOUR LOCAL HOST DIRECTORY ------
						url: 'http://localhost:8888/mergely-3.3.6/examples/<?php echo $get_cust; ?>',
						success: function (response) {
							$('<?php echo "#" . $filenameDIV;?>').mergely('lhs', response);
						}
					});
					$.ajax({
						type: 'GET', async: true, dataType: 'text',
						// CHANGE THIS TO YOUR LOCAL HOST DIRECTORY ------
						url: 'http://localhost:8888/mergely-3.3.6/examples/<?php echo $get_def ?>',
						success: function (response) {
							$('<?php echo "#" . $filenameDIV;?>').mergely('rhs', response);
						}
					});
					
					$( '<?php echo "#" . $filenameDIV . "-btn";?>' ).click(function() {

						var lhscontent = $('<?php echo "#" . $filenameDIV;?>').mergely('get', 'lhs');
						$.ajax({
						    type: 'POST',
						    // CHANGE THIS TO YOUR OWN LOCAL DIRECTORY -----
						    url: 'http://localhost:8888/mergely-3.3.6/examples/writediffy.php',
						    data: { 
						        'filecontents': lhscontent,
								'filed': '<?php echo $group[$groupGET][$i] ?>'
						    },
						    success: function(msg){
						        alert('file sent');
						    }
						});
					  ;
					});
					

				<?php 
			}

			?>
	
			
		});
	</script>
</head>
<body>
	<table border="1" cellpadding="5" cellspacing="0">
		<tr>
			<td>Custom Template</td>
			<td>Default Template</td>
		</tr>
	</table>
	<?php
	$allgroups = count($group) + 1;
	for($i=1; $i<$allgroups; $i++){
		echo "<a href='diffy.php?group=" . $i . "'>Group ". $i . "</a><br />";
	}
	for($i=0; $i<$groupcount; $i++){

			$fullpath = $dirdef  . $group[$groupGET][$i];
			$fullpathcust = $dircust . $group[$groupGET][$i];
			$get_def = "getcontent.php?folder=default&file=" . $group[$groupGET][$i];
			$get_cust = "getcontent.php?folder=custom&file=" . $group[$groupGET][$i];
			$filename = basename($fullpath, ".php");
			$filenameDIV = str_replace(".","-",$filename);
	?>
		<h5><?php echo $filename; ?> </h5>
		<button id="<?php echo $filenameDIV?>-btn">Write Contents</button>
	<div id="<?php echo $filenameDIV ?>"></div>
	<?php  } ?>
</body>
</html>
