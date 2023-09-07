<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$url = array_key_exists('url',$_REQUEST)?$_REQUEST['url']:0;
// Check if the "url" REQUEST variable is set
if ($url != 0) {
	// Get the submitted URL
	$submittedUrl = $_REQUEST["url"];
	#echo $submittedUrl;
	// Include the class file
	require_once "classes/URLProcessor.php";

	// Create an instance of the URLProcessor class
	$urlProcessor = new URLProcessor();
	
	//set desired python script (for the correct model)
	$pythonScript = '/var/www/html/AI-carabids/JORN-14_det.py';

	// Process the submitted URL
	$detoutput = $urlProcessor->processURL($submittedUrl, $pythonScript);

	// Output the processed URL
	header('Content-type: application/json');
	
	include(str_replace("'","",$detoutput));
	
	}
else{
	echo 'No URL submitted.\n';
	echo 'Usage: jorn14.php?url=path/to/image.jpg';
	}

?>
