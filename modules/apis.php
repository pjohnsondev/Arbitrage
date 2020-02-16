<?php
        // This file is used to call each of the application modules on a timer
        // The use of the time prevents api call timeouts and also allows
        // the program to run without cron jobs if necessary

	include 'modules/btc.php';
	include 'modules/coinOne.php';
	include 'modules/btcCoinOne.php';
	include 'modules/btcCoinOneSlips.php';

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