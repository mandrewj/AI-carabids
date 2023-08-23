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

	// Process the submitted URL
	$detoutput = $urlProcessor->processURL($submittedUrl);

	// Output the processed URL
	header('Content-type: application/json');
	include($detoutput);
	
	}
else{
	echo 'No URL submitted.\n';
	echo 'Usage: 5sp.php?url=path/to/image.jpg';
	}

?>
