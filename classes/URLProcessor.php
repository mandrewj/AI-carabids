<?php

class URLProcessor {
    public function processURL($url, $pythonScript = 0) {
        // Sanitize the URL (you may want to perform more validation)
        $sanitizedUrl = filter_var($url, FILTER_SANITIZE_URL);

        // Execute the Python script and get the output
        if ($pythonScript = 0){
        	$pythonScript = '/var/www/html/AI-carabids/5sp_det.py';
        }
        $command = "/usr/bin/python3 $pythonScript " . escapeshellcmd($sanitizedUrl) . " 2>&1";
        #print $command;
        $output = shell_exec($command);
        #print "output ran";

        // Return the output
        header('Content-Type: application/json');
        return $output;
    }
}

?>
