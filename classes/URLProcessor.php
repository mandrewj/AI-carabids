<?php

class URLProcessor {
    public function processURL($url) {
        // Sanitize the URL (you may want to perform more validation)
        $sanitizedUrl = filter_var($url, FILTER_SANITIZE_URL);

        // Execute the Python script and get the output
        $pythonScript = '/var/www/html/AI-carabids/parse.py';
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
