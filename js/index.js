///////////////////
// Coinone  call //
///////////////////
function updateCOne(){
    var market = new XMLHttpRequest();
    market.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var coin = this.responseText;
            if(coin){
            	coin = JSON.parse(coin);
            document.getElementById("coinonexrp").innerHTML = (coin['xrp']).toFixed(2);
            document.getElementById("coinonebch").innerHTML = (coin['bch']).toFixed(2);
            document.getElementById("coinoneeth").innerHTML = (coin['eth']).toFixed(2);
            document.getElementById("coinoneltc").innerHTML = (coin['ltc']).toFixed(2);
            document.getElementById("coinoneetc").innerHTML = (coin['etc']).toFixed(2);
            }
        }
    };   
    market.open("GET", "jsoncoinOne.JSON", true);
    market.send();
};
updateCOne();
var updateC = setInterval(updateCOne, 5000);

//////////////////////
// BTC Markets call //
//////////////////////
function updateBTC(){
    var market = new XMLHttpRequest();
    market.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var coin = this.responseText;
            if(coin){
            	coin = JSON.parse(coin); 
            	var num = coin["num"]["id"];
                document.getElementById("btcxrp").innerHTML = (coin[num]["xrp"]).toFixed(2);
                document.getElementById("btcbch").innerHTML = (coin[num]["bch"]).toFixed(2);
                document.getElementById("btceth").innerHTML = (coin[num]["eth"]).toFixed(2);
                document.getElementById("btcltc").innerHTML = (coin[num]["ltc"]).toFixed(2);
                document.getElementById("btcetc").innerHTML = (coin[num]["etc"]).toFixed(2);
            }
        }
        
    };
    market.open("GET", "jsonbtc.JSON", true);
    market.send();
};
updateBTC();
var updateB = setInterval(updateBTC, 5000);

//////////////////////////
// set high's and low's //
//////////////////////////
function calculateDiff(){
    var currencies = ["xrp", "bch", "eth", "ltc", "etc"];
    var btc, coinone, high, low;
    var market = new XMLHttpRequest();
    market.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var diff = this.responseText;
            if(diff){
            	diff = JSON.parse(diff); 
            currencies.forEach(function(currency){
                document.getElementById(currency+"high").innerHTML = (diff[currency]["high"]["daily"]["extreme%"]).toFixed(2);
                document.getElementById(currency+"low").innerHTML = (diff[currency]["low"]["daily"]["extreme%"]).toFixed(2);
            })
            }
        }
    }
    market.open("GET", "jsonbtcCoinOne.JSON", true);
    market.send();
};
calculateDiff();
var calcDiff = setInterval(calculateDiff, 5000);

///////////////////////
// set average slips //
///////////////////////
function averageSlips(){
    var currencies = ["xrp", "bch", "eth", "ltc", "etc"];
    var market = new XMLHttpRequest();
    market.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var averages = this.responseText;
            if(averages){
            averages = JSON.parse(averages);
            	currencies.forEach(function(currency){
                document.getElementById(currency+"diffaus-ko").innerHTML = averages["toCoinOne"][0][currency]["%"];
                document.getElementById(currency+"diffko-aus").innerHTML = averages["toBtc"][0][currency]["%"];
	        for(i=179; i>=0; i--){
	        	if(averages["toCoinOne"][i][currency]["worstSlip"] !== null){
	                document.getElementById(currency+"avdiffaus-ko").innerHTML = (averages["toCoinOne"][i][currency]["worstSlip"]).toFixed(2);
	                document.getElementById(currency+"avdiffko-aus").innerHTML = (averages["toBtc"][i][currency]["worstSlip"]).toFixed(2);
	                break;
	           	};
	        };
	    });
            };          
       	};
    };
    market.open("GET", "jsonbtcCoinOneSlips.JSON", true);
    market.send();
};
averageSlips();
var avSlips = setInterval(averageSlips, 5000);

                    
     
