<?php
// The following four lines have been removed from Github version for privacy reasons //

// Import PHPMailer classes into the global namespace
// use PHPMailer\PHPMailer\PHPMailer;
// require composer parts 
// require 'vendor/autoload.php';





// set the function
function btcCoinOne(){
    ///////////////////////////////////////////////////////////////////////////////////////
    //                   set target market gap percentages                               //
    //   High is the direction to send money from home exchange the higher the better    //
    //        Low is to return money to the original exchange the lower the better       //
    ///////////////////////////////////////////////////////////////////////////////////////

    $targetHigh = 35;
    $targetLow = 24;

    //grab required databases/Files
    $coinOne = file_get_contents(__DIR__."/../json/coinOne.JSON");
    $btc = file_get_contents(__DIR__."/../json/btc.JSON");
    $btcCoinOne = file_get_contents(__DIR__."/../json/btcCoinOne.JSON");
    
    // convert json data to php associative arrays (hence 'true')
    $coinOne = json_decode($coinOne, true);
    $btc = json_decode($btc, true);
    $btcCoinOne = json_decode($btcCoinOne, true);

    // make sure data is available & not empty
    if(count($coinOne)==0 || count($btc)==0){
    	return;
    }

    //////////////////////////////////////////////////////////
    //    Add 1 to timer for time based storage of data     //
    //  All Modular calculations using $timer are based on  //
    // the current apis.php call rate of 6 times per minute //
    //////////////////////////////////////////////////////////
    if(count($btcCoinOne) !== 0){
        $timer = $btcCoinOne["timer"];
        $timer++;
        $btcCoinOne["timer"] = $timer;
    } else {
        $timer = 1;
    };

    /////////////////////////////////////////
    // define currency values to be looped //
    /////////////////////////////////////////
    $currencies = array("xrp", "bch", "eth", "ltc", "etc");

    ////////////////////////////
    // set new object to edit //
    ////////////////////////////
    $new = $btcCoinOne;
    //////////////////////////////////
    //     create structure for     //
    //     data to store in JSON    //
    //////////////////////////////////
    if(count($new) == 0){
        $base = array(
            "current" => null,
            "%s" => array(),
            "extreme%"=> null,
            "average%"=> null,
            "ranges" => array(
            "1"=> 0,
            "2"=> 0,
            "3"=> 0,
            "4"=> 0,
            "5"=> 0,
            "6"=> 0,
            "7"=> 0,
            "8"=> 0,
            "9"=> 0,
            "10"=> 0,
            "11"=> 0,
            "12"=> 0,
            "13"=> 0,
            "14"=> 0,
            "15"=> 0,
            "16"=> 0,
            "17"=> 0,
            "18"=> 0,
            "19"=> 0,
            "20"=> 0,
            "21"=> 0,
            "22"=> 0,
            "23"=> 0,
            "24"=> 0,
            "25"=> 0,
            "26"=> 0,
            "27"=> 0,
            "28"=> 0,
            "29"=> 0,
            "30"=> 0,
            "31"=> 0,
            "32"=> 0,
            "33"=> 0,
            "34"=> 0,
            "35"=> 0,
            "36"=> 0,
            "37"=> 0,
            "38"=> 0,
            "39"=> 0,
            "40"=> 0
            )
        );
        $level2 = array(
            "hourly" => $base,
            "daily" => $base,
            "weekly" => $base,
            "monthly" => $base
        );
        $level3 = array(
            "high" => $level2,
            "low" => $level2
        );
        $new = array();
        $new += ["timer" => 1];
        // loop through each of 'currencies' to assign the array 
        foreach($currencies as $currency){
            $new += [$currency => $level3];
        }
    };
    

    foreach($currencies as $currency){
        //grab the high and low array for each currency//
        foreach($new[$currency] as $key => $value){
            //grab the high array//
            if($key == "high"){
                //set the high array for editing//
                $high = $new[$currency]["high"];
                // grab each value within high array//
                foreach($high as $key => $value){
                    // grab the hourly array
                    if($key == "hourly"){
                        // set the hourly array for editing//
                        $hourly = $new[$currency]["high"]['hourly'];
                        // grab the current gap and express as a percentage//
                        $current = ($coinOne[$currency]["toCoinOne"]-$btc[$currency]["toCoinOne"])/$btc[$currency]["toCoinOne"]*100;
                        

                        
                        //if $current is > target and previous 'current' < target send alert. This prevents spamming when extreme remains above target//
                        if ($current > $targetHigh && $new[$currency]["high"]['hourly']["current"] < $targetHigh){
                            $percent = round($current, 2);
                            $body = $currency." is at ".$percent."%";
                        
                        //Send text message or email to alert user of opportunity//

                        // Used to send text alert//

                        // Set client with api key and secret for text
                        // $client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic("####", "####"));
                        // //send message using simple api params
                        // $message = $client->message()->send([
                        //     'to' => "number",
                        //     'from' => "NEXMO",
                        //     'text' =>  $body
                        // ]);
                                
                                
                        // Used to send an email alert//

                        // The following was copied from a github repository with minor edits
                        //
                        //     //Create a new PHPMailer instance
                        //     $mail = new PHPMailer;
                        //     //Tell PHPMailer to use SMTP
                        //     $mail->isSMTP();
                        //     //Enable SMTP debugging
                        //     // 0 = off (for production use)
                        //     // 1 = client messages
                        //     // 2 = client and server messages
                        //     $mail->SMTPDebug = 2;
                        //     //Set the hostname of the mail server
                        //     $mail->Host = 'input host here';
                        //     // use
                        //     // $mail->Host = gethostbyname('smtp.gmail.com');
                        //     // if your network does not support SMTP over IPv6
                        //     //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                        //     $mail->Port = 587;
                        //     //Set the encryption system to use - ssl (deprecated) or tls
                        //     $mail->SMTPSecure = 'tls';
                        //     //Whether to use SMTP authentication
                        //     $mail->SMTPAuth = true;
                        //     //Username to use for SMTP authentication - use full email address for gmail
                        //     $mail->Username = "user@example.com";
                        //     //Password to use for SMTP authentication
                        //     $mail->Password = "password";
                        //     //Set who the message is to be sent from
                        //     $mail->setFrom('emailalias@email.com', 'SenderName/Alias');
                        //     //Set an alternative reply-to address
                        //     $mail->addReplyTo('alternative@email.com', 'Alternative Name');
                        //     //Set who the message is to be sent to
                        //     $mail->addAddress('recipient@email.com', 'Recipient Name');
                        //     //Set the subject line
                        //     $mail->Subject = 'Arbitrage notice';
                        //     //Read an HTML message body from an external file, convert referenced images to embedded,
                        //     //convert HTML into a basic plain-text alternative body
                        //     $mail->msgHTML($body);
                        //     //Replace the plain text body with one created manually
                        //     $mail->AltBody = 'This is a plain-text message body';
                        //     //Attach an image file
                        //     // $mail->addAttachment('images/phpmailer_mini.png');
                        //     //send the message, check for errors
                        //     if (!$mail->send()) {
                        //         echo "Mailer Error: " . $mail->ErrorInfo;
                        //     } else {
                        //         echo "Message sent!";
                        //         //Section 2: IMAP
                        //         //Uncomment these to save your message in the 'Sent Mail' folder.
                        //         #if (save_mail($mail)) {
                        //         #    echo "Message saved!";
                        //         #}
                        //     }
                        };


			            $hourly["current"] = $current;
                        //store 60minutes worth of % gaps in the market for later analysis
                        if($hourly["%s"]==null){
                            $hourly["%s"][0] = $current;
                        // Ensure the %s array contains 60min worth of data
                        } else if($timer%6 == 0  && count($hourly['%s']) < 60){
                            array_unshift($hourly['%s'], ($coinOne[$currency]["toCoinOne"]-$btc[$currency]["toCoinOne"])/$btc[$currency]["toCoinOne"]*100);
                        // Add a new entry into the %s array every minute and remove the oldest entry
                        } else if ($timer%6 == 0){
                            array_unshift($hourly['%s'], ($coinOne[$currency]["toCoinOne"]-$btc[$currency]["toCoinOne"])/$btc[$currency]["toCoinOne"]*100);
                            array_pop($hourly['%s']);
                        //make the most recent entry the average of the last 2 calls. This gives the most accurate figure over the course of the minute
                        } else {
                            $hourly["%s"][0] = round(($hourly['%s'][0]+$current)/2, 2);
                        };
                        //Store the most extreme % gap in the market during the last hour
                        if($hourly["extreme%"]==null){
                            $hourly["extreme%"]=$current;
                        } else if($current > $hourly["extreme%"]){
                            $hourly["extreme%"] = $current;
                        }
                        //Store the average % gap in the market for the last hour
                        $hourly["average%"] = array_sum($hourly["%s"])/count($hourly["%s"]);
                        foreach($hourly["ranges"] as $key => $value){
                            for($i=0; $i < count($hourly["%s"]); $i++){
                                if($hourly["%s"][$i] > $key && $hourly["%s"][$i] < $key+1 && $hourly["ranges"][$key] == 0){
                                    $hourly["ranges"][$key] += 1;
                                }
                            }
                        };
                        // store new array to hourly high
                        $new[$currency]["high"]['hourly'] = $hourly;
                    };
                    //Repeat the above for daily storage allowing analysis of daily changes for volatility
                    if($key == "daily"){
                        // set the daily array
                        $daily = $new[$currency]["high"]['daily'];
                        // use timer based on once every 10 seconds for value arrays
                        if($daily["%s"]==null){
                            $daily["%s"][0] = $new[$currency]["high"]['hourly']["average%"];
                        }else if($timer%360 == 0 && count($daily['%s']) < 24){
                            array_unshift($daily['%s'], $new[$currency]["high"]['hourly']["average%"]);
                        } else if ($timer%360 == 0){
                            array_unshift($daily['%s'], $new[$currency]["high"]['hourly']["average%"]);
                            array_pop($daily['%s']);
                        } else {
                            $daily["%s"][0] = round(($daily["%s"][0]+$new[$currency]["high"]['hourly']["average%"])/2, 2);
                        };
                        if($daily["extreme%"]==null){
                            $daily["extreme%"] = $new[$currency]["high"]['hourly']["extreme%"];
                        }else if($new[$currency]["high"]['hourly']["extreme%"] > $daily["extreme%"]){
                            $daily["extreme%"] = $new[$currency]["high"]['hourly']["extreme%"];
                            
                        };
                        $daily["average%"] = array_sum($daily["%s"])/count($daily["%s"]);
                        foreach($daily["ranges"] as $key => $value){
                            for($i=0; $i < count($daily["%s"]); $i++){
                                if($daily["%s"][$i] > $key && $daily["%s"][$i] < $key+1 && $daily["ranges"][$key] == 0){
                                    $daily["ranges"][$key] += 1;
                                }
                            }
                        };
                        // store new array to daily high
                        $new[$currency]["high"]['daily'] = $daily;
                        
                    };
                    //Repeat the above for weekly storage allowing analysis of weekly changes for volatility
                    if($key == "weekly"){
                        // set the weekly array
                        $weekly = $new[$currency]["high"]['weekly'];
                        // use timer based on once every 10 seconds for value arrays
                        if($weekly["%s"]==null){
                            $weekly["%s"][0] = $new[$currency]["high"]['daily']["average%"];
                        }else if($timer%8640 == 0 && count($weekly['%s']) < 7){
                            array_unshift($weekly['%s'], $new[$currency]["high"]['daily']["average%"]);
                        } else if ($timer%8640 == 0){
                            array_unshift($weekly['%s'], $new[$currency]["high"]['daily']["average%"]);
                            array_pop($weekly['%s']);
                        } else {
                            $weekly["%s"][0] = round(($weekly["%s"][0]+$new[$currency]["high"]['daily']["average%"])/2, 2);
                        };
                        if($weekly["extreme%"] == null){
                            $weekly["extreme%"] = $new[$currency]["high"]['daily']["extreme%"];
                        }else if($new[$currency]["high"]['daily']["extreme%"] > $weekly["extreme%"]){
                            $weekly["extreme%"] = $new[$currency]["high"]['daily']["extreme%"];
                        };
                        $weekly["average%"] = array_sum($weekly["%s"])/count($weekly["%s"]);
                        foreach($weekly["ranges"] as $key => $value){
                            for($i=0; $i < count($weekly["%s"]); $i++){
                                if($weekly["%s"][$i] > $key && $weekly["%s"][$i] < $key+1 && $weekly["ranges"][$key] == 0){
                                    $weekly["ranges"][$key] += 1;
                                }
                            }
                        };                            
                        // store new array to weekly high
                        $new[$currency]["high"]['weekly'] = $weekly;
                    };
                    //Repeat the above for monthly storage allowing analysis of monthly changes for volatility
                    if($key == "monthly"){
                        // set the monthly array
                        $monthly = $new[$currency]["high"]['monthly'];
                        // use timer based on once every 10 for 1 week storing values every minute = 60480
                        if($monthly['%s'] == null){
                            $monthly['%s'][0] = $new[$currency]["high"]['weekly']["average%"];
                        } else if($timer%60480 == 0 && count($monthly['%s']) < 4){
                            array_unshift($monthly['%s'], $new[$currency]["high"]['weekly']["average%"]);
                        } else if ($timer%60480 == 0){
                            array_unshift($monthly['%s'], $new[$currency]["high"]['weekly']["average%"]);
                            array_pop($monthly['%s']);
                        } else {
                            $monthly["%s"][0] = round(($monthly["%s"][0]+$new[$currency]["high"]['weekly']["average%"])/2, 2);
                        };
                        if($monthly["extreme%"]==null){
                            $monthly["extreme%"] = $new[$currency]["high"]['weekly']["extreme%"];
                        } else if($new[$currency]["high"]['weekly']["extreme%"] > $monthly["extreme%"]){
                            $monthly["extreme%"] = $new[$currency]["high"]['weekly']["extreme%"];
                        }
                        $monthly["average%"] = array_sum($monthly["%s"])/count($monthly["%s"]); 
                        foreach($monthly["ranges"] as $key => $value){
                            for($i=0; $i < count($monthly["%s"])-1; $i++){
                                if($monthly["%s"][$i+1] > $key && $monthly["%s"][$i+1] < $key+1){
                                    $monthly["ranges"][$key] += 1;
                                }
                            }
                        };                           
                        // store new array to monthly high
                        $new[$currency]["high"]['monthly'] = $monthly;
                    };
                    
                }
            }
            ///////////////////////////////////////////////////////
            //   The process for "high" is repeated for "low"    //
            // This is designed so that money can be returned to //
            // the original exchange at the lowest possible loss //
            ///////////////////////////////////////////////////////
            
            //grab the low array
            if($key = "low"){
                //set the low array
                $low = $new[$currency]["low"];
                // grab each value within low array
                foreach($low as $key => $value){
                    // grab the hourly array
                    if($key == "hourly"){
                        // set the hourly array
            		$hourly = $new[$currency]["low"]['hourly'];
                        $current = ($btc[$currency]["toBtc"]-$coinOne[$currency]["toBtc"])/$coinOne[$currency]["toBtc"]*100;
                        // use timer based on once every 10 seconds for value arrays
                        //if extreme is > 9% send email
	                            if ($current < $targetLow && $new[$currency]["low"]['hourly']["current"] > $targetLow){
	                            $percent = round($current, 2);
	                            $body = $currency." is at ".$percent."%";
                                
                                //Send text message or email to alert user of opportunity//

                                // Set client with api key and secret for text
                                // $client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic("####", "####"));
                                // //send message using simple api params
                                // $message = $client->message()->send([
                                //     'to' => "number",
                                //     'from' => "NEXMO",
                                //     'text' =>  $body
                                // ]);
                                
                                
                                // Used to send an email alert//
                                
	                            //Create a new PHPMailer instance
                                // $mail = new PHPMailer;
                                // //Tell PHPMailer to use SMTP
                                // $mail->isSMTP();
                                // //Enable SMTP debugging
                                // // 0 = off (for production use)
                                // // 1 = client messages
                                // // 2 = client and server messages
                                // $mail->SMTPDebug = 2;
                                // //Set the hostname of the mail server
                                // $mail->Host = 'input host here';
                                // // use
                                // // $mail->Host = gethostbyname('smtp.gmail.com');
                                // // if your network does not support SMTP over IPv6
                                // //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                                // $mail->Port = 587;
                                // //Set the encryption system to use - ssl (deprecated) or tls
                                // $mail->SMTPSecure = 'tls';
                                // //Whether to use SMTP authentication
                                // $mail->SMTPAuth = true;
                                // //Username to use for SMTP authentication - use full email address for gmail
                                // $mail->Username = "user@example.com";
                                // //Password to use for SMTP authentication
                                // $mail->Password = "password";
                                // //Set who the message is to be sent from
                                // $mail->setFrom('emailalias@email.com', 'Sender Name/Alias');
                                // //Set an alternative reply-to address
                                // $mail->addReplyTo('alternative@email.com', 'Alternative Name');
                                // //Set who the message is to be sent to
                                // $mail->addAddress('recipient@email.com', 'Recipient Name');
                                // //Set the subject line
                                // $mail->Subject = 'Arbitrage notice';
                                // //Read an HTML message body from an external file, convert referenced images to embedded,
                                // //convert HTML into a basic plain-text alternative body
                                // $mail->msgHTML($body);
                                // //Replace the plain text body with one created manually
                                // $mail->AltBody = 'This is a plain-text message body';
                                // //Attach an image file
                                // // $mail->addAttachment('images/phpmailer_mini.png');
                                // //send the message, check for errors
                                // if (!$mail->send()) {
                                //     echo "Mailer Error: " . $mail->ErrorInfo;
                                // } else {
                                //     echo "Message sent!";
                                //     //Section 2: IMAP
                                //     //Uncomment these to save your message in the 'Sent Mail' folder.
                                //     #if (save_mail($mail)) {
                                //     #    echo "Message saved!";
                                //     #}
                                // }
                        	};
                        $hourly["current"] = $current;
                        //set each value within the hourly array
                        // use timer based on once every 10 seconds for value arrays
                        if($hourly["%s"] == null){
                            $hourly["%s"][0] = $current;
                        } else if($timer%6 == 0 && count($hourly['%s']) < 60){
                            array_unshift($hourly['%s'], ($btc[$currency]["toBtc"]-$coinOne[$currency]["toBtc"])/$coinOne[$currency]["toBtc"]*100);
                        } else if ($timer%6 == 0){
                            array_unshift($hourly['%s'], ($btc[$currency]["toBtc"]-$coinOne[$currency]["toBtc"])/$coinOne[$currency]["toBtc"]*100);
                            array_pop($hourly['%s']);
                        } else {
                            $hourly["%s"][0] = round(($hourly["%s"][0]+$current)/2, 2);
                        };
                        if($hourly["extreme%"]==null){
                            $hourly["extreme%"] = $current;
                        } else if($current < $hourly["extreme%"]){
                            $hourly["extreme%"] = $current;
                        }
                        $hourly["average%"] = array_sum($hourly["%s"])/count($hourly["%s"]);
                        foreach($hourly["ranges"] as $key => $value){
                            for($i=0; $i < count($hourly["%s"]); $i++){
                                if($hourly["%s"][$i] > $key && $hourly["%s"][$i] < $key+1 && $hourly["ranges"][$key] == 0){
                                    $hourly["ranges"][$key] += 1;
                                }
                            }
                        };                            
                        // store new array to hourly low
                        $new[$currency]["low"]['hourly'] = $hourly;
                    };
                    if($key == "daily"){
                        // set the daily array
                        $daily = $new[$currency]["low"]['daily'];
                        // use timer based on once every 10 seconds for value arrays
                        if($daily['%s'] ==null){
                            $daily['%s'][0] = $new[$currency]["low"]['hourly']["average%"];
                        } else if(count($hourly['%s']) > 60){
                        	array_pop($hourly['%s']);
                        }else if($timer%360 == 0 && count($daily['%s']) < 24){
                            array_unshift($daily['%s'], $new[$currency]["low"]['hourly']["average%"]);
                        } else if ($timer%360 == 0){
                            array_unshift($daily['%s'], $new[$currency]["low"]['hourly']["average%"]);
                            array_pop($daily['%s']);
                        } else {
                            $daily["%s"][0] = round(($daily["%s"][0]+$new[$currency]["low"]['hourly']["average%"])/2, 2);
                        };
                        if($daily["extreme%"] == null){
                            $daily["extreme%"] = $new[$currency]["low"]['hourly']["extreme%"];
                        } else if($new[$currency]["low"]['hourly']["extreme%"]<$daily["extreme%"]){
                            $daily["extreme%"] = $new[$currency]["low"]['hourly']["extreme%"];
                        };
                        $daily["average%"] = array_sum($daily["%s"])/count($daily["%s"]);
                        foreach($daily["ranges"] as $key => $value){
                            for($i=0; $i < count($daily["%s"]); $i++){
                                if($daily["%s"][$i] > $key && $daily["%s"][$i] < $key+1 && $daily["ranges"][$key] == 0){
                                    $daily["ranges"][$key] += 1;
                                }
                            }
                        };
                        // store new array to daily low
                        $new[$currency]["low"]['daily'] = $daily;
                    };
                    if($key == "weekly"){
                        // set the weekly array
                        $weekly = $new[$currency]["low"]['weekly'];
                        // use timer based on once every 10 seconds for value arrays
                        if($weekly['%s']==null){
                            $weekly['%s'][0] = $new[$currency]["low"]['daily']["average%"];
                        }else if($timer%8640 == 0 && count($weekly['%s']) < 7){
                            array_unshift($weekly['%s'], $new[$currency]["low"]['daily']["average%"]);
                        } else if ($timer%8640 == 0){
                            array_unshift($weekly['%s'], $new[$currency]["low"]['daily']["average%"]);
                            array_pop($weekly['%s']);
                        } else {
                            $weekly["%s"][0] = round(($weekly["%s"][0]+$new[$currency]["low"]['daily']["average%"])/2, 2);
                        };
                        if($weekly["extreme%"] == null){
                            $weekly["extreme%"] = $new[$currency]["low"]['daily']["extreme%"];
                        }else if($new[$currency]["low"]['daily']["extreme%"] < $weekly["extreme%"]){
                            $weekly["extreme%"] = $new[$currency]["low"]['daily']["extreme%"];
                        }
                        $weekly["average%"] = array_sum($weekly["%s"])/count($weekly["%s"]);
                        foreach($weekly["ranges"] as $key => $value){
                            for($i=0; $i < count($weekly["%s"]); $i++){
                                if($weekly["%s"][$i] > $key && $weekly["%s"][$i] < $key+1 && $weekly["ranges"][$key] == 0){
                                    $weekly["ranges"][$key] += 1;
                                }
                            }
                        };
                        // store new array to weekly low
                        $new[$currency]["low"]['weekly'] = $weekly;
                    };
                    if($key == "monthly"){
                        // set the monthly array
                        $monthly = $new[$currency]["low"]['monthly'];
                        // use timer based on once every 10 seconds for value arrays
                        if($monthly['%s'] == null){
                            $monthly['%s'][0] = $new[$currency]["low"]['weekly']["average%"];
                        } else if($timer%60480 == 0 && count($monthly['%s']) < 4){ 
                            array_unshift($monthly['%s'], $new[$currency]["low"]['weekly']["average%"]);
                        } else if ($timer%259200 == 0){
                            array_unshift($monthly['%s'], $new[$currency]["low"]['weekly']["average%"]);
                            array_pop($monthly['%s']);
                        } else {
                            $monthly["%s"][0] = round(($monthly["%s"][0]+$new[$currency]["low"]['weekly']["average%"])/2, 2);
                        };
                        if($monthly["extreme%"] == null){
                            $monthly["extreme%"] = $new[$currency]["low"]['weekly']["extreme%"];
                        } else if($new[$currency]["low"]['weekly']["extreme%"] < $monthly["extreme%"]){
                            $monthly["extreme%"] = $new[$currency]["low"]['weekly']["extreme%"];
                        };
                        $monthly["average%"] = array_sum($monthly["%s"])/count($monthly["%s"]);
                        foreach($monthly["ranges"] as $key => $value){
                            for($i=0; $i < count($monthly["%s"]); $i++){
                                if($monthly["%s"][$i] > $key && $monthly["%s"][$i] < $key+1 && $monthly["ranges"][$key] == 0){
                                    $monthly["ranges"][$key] += 1;
                                }
                            }
                        };
                        // store new array to monthly low
                        $new[$currency]["low"]['monthly'] = $monthly;
                    };
                    
                }
            }
        }

        };
    $new = json_encode($new);
    file_put_contents(__DIR__."/../json/btcCoinOne.JSON", $new);
        
    };

?>
