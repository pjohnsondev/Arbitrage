<?php

   //This function calls on the coinone api and stores the current bid and ask prices
   // The ask is stored as "toCoinOne" as it is immediately purchasable price for sending coins to another exchange
   // The bid is stored as "toBtc" as it is the immediately sellable price for quick conversion to aud when returning 
   // coins to the exchange 

function coinOneApi(){
    $json = file_get_contents("json/coinOne.JSON");
    $json = json_decode($json, true);
    if(gettype($json["xrp"]) !== 'array'){
    	$json = array(
    		"exchange" => array("rate"=> 856),
    		"xrp" => array(
                "toCoinOne" => 0,
                "toBtc" => 0),
			"bch" => array(
                "toCoinOne" => 0,
                "toBtc" => 0),
			"eth" => array( 
                "toCoinOne" => 0,
                "toBtc" => 0),
    		"ltc" => array(
                "toCoinOne" => 0,
                "toBtc" => 0),
    		"etc" => array(
                "toCoinOne" => 0,
                "toBtc" => 0),    	
    		);
    };
   
    $currencies = array("xrp", "bch", "eth", "ltc", "etc");
    foreach($currencies as $currency){
        $url = 'https://api.coinone.co.kr/orderbook?currency='.$currency;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $sent = json_decode($data, true);
        if($sent['bid']){
            $json[$currency]["toCoinOne"] = ($sent['bid'][0]["price"]/$json["exchange"]["rate"]);
            $json[$currency]["toBtc"] = ($sent['ask'][0]["price"]/$json["exchange"]["rate"]);
        };
    };
    $json = json_encode($json);
    file_put_contents('json/coinOne.JSON', $json);
    
};
?>