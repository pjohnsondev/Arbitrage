<?php
        // This file is used to call each of the application modules on a timer
        // The use of the time prevents api call timeouts and also allows
        // the program to run without cron jobs if necessary

	include __DIR__.'/btc.php';
	include __DIR__.'/coinOne.php';
	include __DIR__.'/btcCoinOne.php';
        include __DIR__.'/btcCoinOneSlips.php';

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