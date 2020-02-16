<?php

   //This function calls on the btcmarkets.net api and stores the current bid and ask prices
   // The ask is stored as "toCoinOne" as it is immediately purchasable price for sending coins to another exchange
   // The bid is stored as "toBtc" as it is the immediately sellable price for quick conversion to aud when returning 
   // coins to the exchange 


function btcApi(){
    $json = file_get_contents("json/btc.JSON");
    // $json = json_decode($json);
    $json = json_decode($json, true);
    echo gettype($json);
    
    if(!array_key_exists("currency", $json)){
        $json = array();
    };
    // $BTCValues = array();
    $currencies = array("XRP", "BCH", "ETH", "LTC", "ETC");
    foreach ($currencies as $currency) {
        $url = 'https://api.btcmarkets.net/market/'.$currency."/AUD/tick";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $sent = json_decode($data, true);
        if(!$sent['bestBid']){
            exit;
        }
        $currency = strtolower($currency);
        if(!array_key_exists("currency", $json)){
            $json += [$currency => array(
                "toCoinOne" => $sent["bestAsk"],
                "toBtc" => $sent["bestBid"]            
            )];
        } else {
            $json[$currency]["toCoinOne"] = $sent["bestAsk"];
            $json[$currency]["toBtc"] = $sent["bestBid"];
        }
    };
    $json = json_encode($json);
    file_put_contents('json/btc.JSON', $json);
};
btcApi();
?>