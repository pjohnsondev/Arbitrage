<?php
        // This file is used to call each of the application modules on a timer
        // The use of the time prevents api call timeouts and also allows
        // the program to run without cron jobs if necessary

	include '/Library/WebServer/Documents/public_html/modules/btc.php';
	include '/Library/WebServer/Documents/public_html/modules/coinOne.php';
	include '/Library/WebServer/Documents/public_html/modules/btcCoinOne.php';
	include '/Library/WebServer/Documents/public_html/modules/btcCoinOneSlips.php';

function loop(){
        $t = 0;
        while($t < 6){
         btcApi();
         coinOneApi();
         btcCoinOne();
         slips();
         $t++;
         sleep(10);
        };
};
 loop();

?>