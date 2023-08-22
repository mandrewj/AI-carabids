<!DOCTYPE html>
<html>
<head>
    <title>URL Processor</title>
</head>
<body>
    <h1>URL Processor</h1>

    <?php
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the "url" POST variable is set
        if (isset($_POST["url"])) {
            // Get the submitted URL
            $submittedUrl = $_POST["url"];
            
            // Include the class file
            require_once "classes/URLProcessor.php";

            // Create an instance of the URLProcessor class
            $urlProcessor = new URLProcessor();

            // Process the submitted URL
            $processedUrl = $urlProcessor->processURL($submittedUrl);

            // Output the processed URL
            echo "<p>Processed URL: <a href='$processedUrl' target='_blank'>$processedUrl</a></p>";
        } else {
            echo "<p>Error: Please provide a URL.</p>";
        }
    }
    ?>

    <form method="post" action="">
        <label for="url">Enter URL:</label>
        <input type="text" name="url" id="url" required>
        <button type="submit">Process URL</button>
    </form>
</body>
</html>
