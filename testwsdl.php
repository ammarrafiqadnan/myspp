<?php

ini_set("soap.wsdl_cache_enabled", "0");

// Point to the WSDL file
$wsdl_url = "https://10.29.25.144/myspp/wsdl/crsservice.wsdl";

try {
	
	$options = [
		'stream_context' => stream_context_create([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
			]
		])
	];
	
    // Create a new instance of the SoapClient class
    $client = new SoapClient($wsdl_url, $options);

    // List available operations
    print_r($client->__getFunctions());

    $requestParams = array(
        'AgencyCode' => 'SPPTQQBSE',
        'BranchCode' => 'MySPP',
        'UserId' => '10.29.25.144',
        'TransactionCode' => 'SPP14717',
        'RequestDateTime' => '2023-03-11T11:34:00',
        'ICNumber' => '981210105128', 
        'RequestIndicator' => 'A'
    );

    // Call the operation
    $result = $client->__soapCall("retrieveCitizensData", array($requestParams));
    print_r($result);
} catch (SoapFault $e) {
    echo "SOAP Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
