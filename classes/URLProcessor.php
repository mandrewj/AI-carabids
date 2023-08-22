<?php

class URLProcessor {
    public function processURL($url) {
        // Sanitize the URL (you may want to perform more validation)
        $sanitizedUrl = filter_var($url, FILTER_SANITIZE_URL);

        // Execute the Python script and get the output
        $pythonScript = 'parse.py';
        $command = "python3 $pythonScript " . escapeshellcmd($sanitizedUrl);
        print $command ;
        //$output = shell_exec($command);
        $output=null;
        $retval=null;
        exec($command, $output, $retval);
        echo "Returned with status $retval and output:\n";
        print_r($output)
        print "output ran";

        // Return the output
        //header('Content-Type: application/json');
        return $output;
    }
}

?>
