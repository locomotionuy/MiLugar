<?php 
function limpiar($s) 
{ 
$s= str_replace('á', 'a', $s); 
$s= str_replace('é', 'e', $s); 
$s= str_replace('í', 'i', $s); 
$s= str_replace('ó', 'o', $s); 
$s= str_replace('ú', 'u', $s); 
$s= str_replace('ü', 'u', $s); 
$s= str_replace('ñ', 'n', $s); 
$s= str_replace(',', '', $s); 
$s= str_replace(' ', '', $s);
$s= str_replace('(', '_', $s);
$s= str_replace(')', '_', $s);
return $s; 
}
function limpiar_numeros($r){ 
	$r= str_replace('$', '', $r); 
	$r= str_replace('.', '', $r); 
	$r= str_replace(',', '', $r); 
	$r= str_replace(' ', '', $r); 
	return $r; 
}
function convertCurrency($from,$to,$amount){
	$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
	$response_json = file_get_contents($req_url);
	if(false !== $response_json) {
		try {
		$response_object = json_decode($response_json);
		$base_price = 1; // Your price in USD
		$USD_cotizacion = round(($base_price * $response_object->rates->UYU), 2);
			//error_log('USD_cotizacion '.$USD_cotizacion);
			return $USD_cotizacion;
		}
		catch(Exception $e) {
			// Handle JSON parse error...
		}

	}
   /* $url = "https://www.google.com/search?q=".$from.$to;
    $request = curl_init();
    $timeOut = 0;
    curl_setopt ($request, CURLOPT_URL, $url);
    curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($request, CURLOPT_USERAGENT,"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36");
    curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
    $response = curl_exec($request);
    curl_close($request);

    preg_match('~<span [^>]* id="knowledge-currency__tgt-amount"[^>]*>(.*?)</span>~si', $response, $finalData);
    return floatval(floatval(preg_replace("/[^-0-9\.]/","", $finalData[1])) * $amount);*/
}
?>