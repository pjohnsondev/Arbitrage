<?php
//////////////////////////////////////////////////////////////////////////////
//    Used to check how volatile the market has been over the preceeding    //
//  30 minutes. This is a safeguard as many coins take 20-30minutes to move //
//    between exchanges and volatility could cause loss instead of gains    //
//   based on running script 10 times per minute for a 30minute calculation //
//             this gives us 180 hence storing 0-179 for each               //
//////////////////////////////////////////////////////////////////////////////
function slips(){
    $btc = file_get_contents(__DIR__."/../json/btc.JSON");
    $coinOne = file_get_contents(__DIR__."/../json/coinOne.JSON");
    $slips = file_get_contents(__DIR__."/../json/btcCoinOneSlips.JSON");
    $btc = json_decode($btc, true);
    $coinOne = json_decode($coinOne, true);
    $slips = json_decode($slips, true);
    $currencies = array("xrp", "bch", "eth", "ltc", "etc");

    ///////////////////////////////////
    // check if the JSON data exists //
    ///////////////////////////////////
    if(!$btc || !$coinOne){
    	return;
    }
    
    // This will create a new JSON object if starting from scratch
    // 
    if(!$slips){
    	// exit;
        // if not, create object model
        $currencyArray = array();
        $currencyArray += ["price" => null];
        $currencyArray += ["%" => null];
        $currencyArray += ["bestSlip" => null];
        $currencyArray += ["worstSlip" => null];
        $currencyArray += ["averageSlip" => null];
        // set object
        $slips["toCoinOne"] = array();
        $slips["toBtc"] = array();
        for($i=0; $i<=179; $i++){
            $slips["toCoinOne"][$i] = array();
            $slips["toBtc"][$i] = array();
        };
        foreach($currencies as $currency){
            for($i=0; $i<=179; $i++){
                $slips["toCoinOne"][$i] += array($currency => $currencyArray);
                $slips["toBtc"][$i] += array($currency => $currencyArray);
            };
        }
    };

    //////////////////////////////////////////
    // Move each coin object forward by one //
    //     in order to reference forward    //
    //////////////////////////////////////////
    for($i=179; $i >=0; $i--){
        $newKey = $i+1;
        if($i == 179){ 
            unset($slips["toBtc"][$i]);
            unset($slips["toCoinOne"][$i]);
        } else {
                $temp = $slips['toBtc'][$i];
                unset($slips['toBtc'][$i]);
                $slips['toBtc'][$newKey] = $temp;
                $temp = $slips['toCoinOne'][$i];
                unset($slips['toCoinOne'][$i]);
                $slips['toCoinOne'][$newKey] = $temp;
        };
    };
        
    // coinOne //
    foreach($currencies as $currency){
        ///////////////////////////////////////////////////////////
        // setup #1 array with price of btc markets current sell //
        //  this will be used to find the percentage diff when   //
        //  compared to the slip at "all" that will be added     //
        //  each cycle by calculating the diff between "price"    //
        //           and the lastest coinone price               //
        ///////////////////////////////////////////////////////////
        $currencyArray = array();
        // Get the current purchase price at btcmarkets exchange
        $currencyArray += ["price" => round($btc[$currency]["toCoinOne"], 2)];
        // get the current % gap between the two markets
        $currencyArray += ["%" => round(((($coinOne[$currency]["toCoinOne"]-$btc[$currency]["toCoinOne"])/$btc[$currency]["toCoinOne"])*100), 2)];
        $currencyArray += ["bestSlip" => null];
        $currencyArray += ["worstSlip" => null];
        $currencyArray += ["averageSlip" => null];
        $slips["toCoinOne"][0][$currency] = $currencyArray;
        ////////////////////////////////////////////////////
        // add current values to each array and calculate //
        ////////////////////////////////////////////////////
        for($i=1; $i<=179; $i++){
            if(!isset($slips["toCoinOne"][$i][$currency]["price"])){
                continue;
            } else {;
                //grab original price array for calculations
                $price = $slips["toCoinOne"][$i][$currency]["price"];
                // set editable variable to current array for editing
                $slip = $slips["toCoinOne"][$i][$currency];
                //set value equal to most recent % to aid in calculation of slips
                $currentPercent = round(($coinOne[$currency]["toCoinOne"]-$price)/$price*100, 2);
                $currentSlip = round($currentPercent-$slip["%"], 2);
                //check if there is a bestSlip in current array
                // the bestSlip is the lowest change in % gap over the time period
                if(!isset($slip["bestSlip"])){
                    //if not, set
                    $slip["bestSlip"] = round($currentPercent-$slip["%"], 2);
                } else if($currentPercent-$slip["%"] > $slip["bestSlip"]){
                    $slip["bestSlip"] = round($currentPercent-$slip["%"], 2);
                };
                //check if there is a worstSlip is current array
                //The worstSlip is the biggest % gap change over the time period
                if(!isset($slip["worstSlip"])){
                    //if not, set
                    $slip["worstSlip"] = round($currentPercent-$slip["%"], 2);
                } else if($currentPercent-$slip["%"] < $slip["worstSlip"]){
                    $slip["worstSlip"] = round($currentPercent-$slip["%"], 2);
                };
                //check if there is an average slip
                if(!isset($slip["averageSlip"])){
                    //if not, set
                    $slip["averageSlip"] = $currentSlip;
                } else {
                    $slip["averageSlip"] = round(($slip["averageSlip"]+$currentSlip)/2, 2);
                }
                //set current array to edited version to
                $slips["toCoinOne"][$i][$currency] = $slip;
            };
        };

    };
    // btc //
    foreach($currencies as $currency){
        ///////////////////////////////////////////////////////////
        // setup #1 array with price of btc markets current sell //
        //  this will be used to find the percentage diff when   //
        //  compared to the slip at "all" that will be added     //
        //  each cycle by calculating te diff between "price"    //
        //            and the latest btc price                   //
        ///////////////////////////////////////////////////////////
        $currencyArray = array();
        $currencyArray += ["price" => round($coinOne[$currency]["toBtc"], 2)];
        $currencyArray += ["%" => round(((($btc[$currency]["toBtc"]-$coinOne[$currency]["toBtc"])/$coinOne[$currency]["toBtc"])*100), 2)];       
        $currencyArray += ["bestSlip" => null];
        $currencyArray += ["worstSlip" => null];
        $currencyArray += ["averageSlip" => null];
        $slips["toBtc"][0][$currency] = $currencyArray;
        ////////////////////////////////////////////////////
        // add current values to each array and calculate //
        ////////////////////////////////////////////////////
        for($i=1; $i<=179; $i++){
            if(!isset($slips["toBtc"][$i][$currency]['price'])){
                continue;
            } else {;
                //grab original price for array for calculations
                $price = $slips["toBtc"][$i][$currency]["price"];
                // set editable variable to current array for editing
                $slip = $slips["toBtc"][$i][$currency];
                //set value equal to most recent % to aid in calculation of slips
                $currentPercent = round(($btc[$currency]["toBtc"]-$price)/$btc[$currency]["toBtc"]*100, 2);
                $currentSlip = round($slip["%"]-$currentPercent, 2);
                //check if there is a bestSlip in current array
                if(!isset($slip["bestSlip"])){
                    //if not, set
                    $slip["bestSlip"] = round($slip["%"]-$currentPercent, 2);
                    //else check if most recent % is better slip
                } else if($slip["%"]-$currentPercent > $slip["bestSlip"]){
                    $slip["bestSlip"] = round($slip["%"]-$currentPercent, 2);
                };
                //check if there is a worstSlip is current array
                if(!isset($slip["worstSlip"])){
                    //if not, set
                    $slip["worstSlip"] = round($currentPercent-$slip["%"], 2);
                    //else check if most recent % is a worse slip
                } else if($slip["%"]-$currentPercent < $slip["worstSlip"]){
                    $slip["worstSlip"] = round($slip["%"]-$currentPercent, 2);
                };
                //check if there is an average slip
                if(!isset($slip["averageSlip"])){
                    //if not, set
                    $slip["averageSlip"] = $currentSlip;
                } else {
                    $slip["averageSlip"] = round(($slip["averageSlip"]+$currentSlip)/2, 2);
                }
                //set current array to edited version to
                $slips["toBtc"][$i][$currency] = $slip;
            };
        };

    };
    $slips = json_encode($slips);
    file_put_contents(__DIR__."/../json/btcCoinOneSlips.JSON", $slips);
};

?>