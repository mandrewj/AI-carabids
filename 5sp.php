<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "url" POST variable is set
    if (isset($_GET["url"])) {
        // Get the submitted URL
        $submittedUrl = $_POST["url"];
        echo $submittedUrl;
        // Include the class file
        require_once "classes/URLProcessor.php";

        // Create an instance of the URLProcessor class
        $urlProcessor = new URLProcessor();

        // Process the submitted URL
        $detoutput = $urlProcessor->processURL($submittedUrl);

        // Output the processed URL
		header('Content-type: application/json');
		echo json_encode( $data );
        }
    else{
    	echo 'No URL submitted.';
    	echo 'Usage: 5sp.php?url=path/to/image.jpg';
    	}
    }
else{
	echo 'no get statements given';
	echo 'Usage: 5sp.php?url=path/to/image.jpg';}
?>
