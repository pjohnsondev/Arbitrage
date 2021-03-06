<?php

// This function converts Korean Won into Australian Dollars using the fixer exchange rate api
// This needs to be called daily. Best done with Cronjob or similar

function krwaud(){
	$co = file_get_contents(__DIR__."/../json/coinOne.JSON");
	$co = json_decode($co, true);
        $url = 'https://api.exchangeratesapi.io/latest?base=AUD&symbols=KRW';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$sent = json_decode($data, true);
	if(!$sent["rates"]["KRW"]){
		exit;
	}
	$parseRate = $sent["rates"]["KRW"];
	$parseRate = floatval($parseRate);
	$co["exchange"]["rate"] = $parseRate;
	$co = json_encode($co);
	file_put_contents(__DIR__."/../json/coinOne.JSON", $co);
};
krwaud();
?>
