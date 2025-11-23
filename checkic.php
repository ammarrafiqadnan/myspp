<?php
// Initialize cURL session
$curl = curl_init();

// Set the URL for the request
curl_setopt($curl, CURLOPT_URL, 'http://10.29.25.144:8080/verification/verify.asm?ICNumber=700526015475');

// Set the HTTP method for the request
curl_setopt($curl, CURLOPT_HTTPGET, true);

// Set the headers for the request (optional)
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept : application/json',
    'Secret: 6ff9e91765872e32c4927ce76dee3084',

));

// Execute the request and store the response in a variable
$response = curl_exec($curl);

// Check for any errors during the request
if(curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
}

// Close the cURL session
curl_close($curl);

// Output the response
echo $response;

?>