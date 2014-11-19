<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<title></title>
	</head>
	<body style="background-color: #000000;font-family: Arial;">
<?php

# The Email List Extractor - Mark Coleman

if (!is_dir('output')) {
    mkdir('output');
}

foreach (glob("output/*.*") as $trash) {
   unlink($trash);
}

$fileName = $_REQUEST['fileName']; 

if (isset($_FILES['upload']['tmp_name']) && !empty($_FILES["upload"]['tmp_name'])) {
	// get text from file
	$text = trim(file_get_contents($_FILES['upload']['tmp_name']));
}
elseif (isset($_REQUEST['text']) && !empty($_REQUEST['text'])) {
	// get text from text area
	$text = trim($_REQUEST['text']);
}
?>
<table align="center" style="background-color: #FFFFFF;" cellpadding="10px">
<tbody><tr><td>
<h1 style="font-family: arial black;text-align: center;margin:0;">Email List Extractor Results</h1>

<?php
// parse emails
if (!empty($text)) {
	$res = preg_match_all("/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i", $text,$matches);
	#$res = preg_match_all("/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*([ ]+|)@{1,}([ ]+|)([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i", $text,$matches);
	#$res = preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $text,$matches);
    echo '<br /><strong>EXTRACTION RESULTS</strong><br /><div align="right"><a href="index.html" alt="">START OVER</a></div><hr />';
	if ($res) {
		$fh = fopen("output/".$fileName, 'w');
		echo '<strong>Email Addresses have been Extracted!</strong><br /><br />';
		echo '<strong>Download the output file (right-click &amp; save as): <a style="color: red;" href="output/'.$fileName.'">'.$fileName.'</a><br />or highlight and copy the list below</strong><br /><br /> ---- begin email list ----<br /><br />';
		foreach($matches[0] as $email) {
			#$email = str_replace(" ","",str_replace("@@","@",$email));
			echo $email . '<br />';
			$fh = fopen("output/".$fileName, 'a');
			
			fwrite($fh,trim($email)."\r\n");
			fclose($fh);
		}
	echo '<br /> ---- end email list ----<br />';
	}
	else {
		echo "<br />No emails found.<br /><br />";
		echo '<a href="index.html">TRY AGAIN</a><br />';
	} 
}
else {
	echo "There was no data to parse!<br /><br />";
	echo '<a href="index.html">TRY AGAIN</a>';
}

?>
<br /><hr />
<div align="right"><a href="index.html">START OVER</a></div>
<div style="font-size:8pt;color:#999999;text-align:center;"><br /><br /><hr>Email List Extractor v1.0.7b by Mark Coleman, Tier 2, Constant Contact Inc.</div>
</td></tr></tbody></table>
<?php
exit();
?>

	</body>
</html>