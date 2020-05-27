<?php 
/*
$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

if(false !== $response_json) {

    try {

	// Decoding
	$response_object = json_decode($response_json);

	// YOUR APPLICATION CODE HERE, e.g.
	$base_price = 12; // Your price in USD
	$UYU_price = round(($response_object->rates->UYU), 2);

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }

}
*/
function conversor_monedas($moneda_origen,$moneda_destino,$cantidad) {
  $get = file_get_contents("https://www.google.com/finance/converter?a=$cantidad&from=$moneda_origen&to=$moneda_destino");
	echo $get;
  $get = explode("<span class=bld>",$get);
  $get = explode("</span>",$get[1]);  
  return preg_replace("/[^0-9\.]/", null, $get[0]);
}

//echo conversor_monedas("USD","EUR",1);
/*
function convertCurrency($from,$to,$amount){
    $url = "https://www.google.com/search?q=".$from.$to;
    $request = curl_init();
    $timeOut = 0;
    curl_setopt ($request, CURLOPT_URL, $url);
    curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36");
    curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
    $response = curl_exec($request);
    curl_close($request);
//print_r($response);
    preg_match('~<span [^>]* id="knowledge-currency__updatable-data-column"[^>]*>(.*?)</span>~si', $response, $finalData);
	
	//<div class="nRbRnb" id="knowledge-currency__updatable-data-column"><div class="b1hJbf" data-exchange-rate="37.131">
    return floatval(floatval(preg_replace("/[^-0-9\.]/","", $finalData[1])) * $amount);
}
echo convertCurrency("USD","UYU",1);*/
$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

	// Decoding
	$response_object = json_decode($response_json);

	// YOUR APPLICATION CODE HERE, e.g.
	$base_price = 1; // Your price in USD
	$EUR_price = round(($base_price * $response_object->rates->UYU), 2);
		echo $EUR_price;
    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }

}
/*
function currencyConverter($currency_from,$currency_to,$currency_input){
    $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from yahoo.finance.xchange where pair in ("'.$currency_from.$currency_to.'")';
    $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
    $yql_query_url .= "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
    $yql_session = file_get_contents($yql_query_url);
    $yql_json =  json_decode($yql_session,true);
	
	print_r($yql_json);
    $currency_output = (float) $currency_input*$yql_json['query']['results']['rate']['Rate'];

    return $currency_output;
}

 $currency_input = 2;
 //currency codes : http://en.wikipedia.org/wiki/ISO_4217
 $currency_from = "USD";
 $currency_to = "EUR";
 $currency = currencyConverter($currency_from,$currency_to,$currency_input);

 echo $currency_input.' '.$currency_from.' = '.$currency.' '.$currency_to;
*/
?>