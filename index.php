<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Money Maker</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container">
<div class="table">
<table>
        <tr>
            <th>Coin</th>
            <th>Aus</th>
            <th>Ko</th>
            <th>%aus-ko</th>
            <th>Slip</th>
            <th>%ko-aus</th>
            <th>Slip</th>
            <th>24h High</th>
            <th>24h Low</th>
        </tr>
        <tr> 
            <td>xrp</td>
            <td id="btcxrp"><?php  ?></td>
            <td id="coinonexrp">CoinOneXRP</td>
            <td id="xrpdiffaus-ko">0</td>
            <td id="xrpavdiffaus-ko"></td>
            <td id="xrpdiffko-aus">0</td>
            <td id="xrpavdiffko-aus"></td> 
            <td id="xrphigh">0</td>
            <td id="xrplow">100</td>
        </tr>
        <tr>
            <td>bch</td>
            <td id="btcbch">BTCBcash</td>
            <td id="coinonebch">CoinOneBcash</td>
            <td id="bchdiffaus-ko">0</td>
            <td id="bchavdiffaus-ko"></td>
            <td id="bchdiffko-aus">0</td>
            <td id="bchavdiffko-aus"></td>
            <td id="bchhigh">0</td>
            <td id="bchlow">100</td>
        </tr>
        <tr>
            <td>eth</td>
            <td id="btceth">BTCEth</td>
            <td id="coinoneeth">CoinOneEth</td>
            <td id="ethdiffaus-ko">0</td>
            <td id="ethavdiffaus-ko"></td>
            <td id="ethdiffko-aus">0</td>
            <td id="ethavdiffko-aus"></td>
            <td id="ethhigh">0</td>
            <td id="ethlow">100</td>
        </tr>
        <tr>
            <td>ltc</td>
            <td id="btcltc">BTCLite</td>
            <td id="coinoneltc">CoinOneLite</td>
            <td id="ltcdiffaus-ko">0</td>
            <td id="ltcavdiffaus-ko"></td>
            <td id="ltcdiffko-aus">0</td>
            <td id="ltcavdiffko-aus"></td>
            <td id="ltchigh">0</td>
            <td id="ltclow">100</td>
        </tr>
        <tr> 
            <td>etc</td>
            <td id="btcetc">BTCLite</td>
            <td id="coinoneetc">CoinOneLite</td>
            <td id="etcdiffaus-ko">0</td>
            <td id="etcavdiffaus-ko"></td>
            <td id="etcdiffko-aus">0</td>
            <td id="etcavdiffko-aus"></td>
            <td id="etchigh">0</td>
            <td id="etclow">100</td>
        </tr>
        </table>
        </div>
        <div class="calc">
        <div class="space"></div>
        <div class="calc-head">
        <h4>calculate profit</h4>
        </div>
        <div class="aus-ko">
            <form action="">
                <label for="spend">Amount to spend: &nbsp</label>
                <input type="text" id="spend" name="spend">
            </form>
            <table>
                <tr>
                    <th>Coin</th>
                    <th>Value in Korea</th>
                </tr>
                <tr>
                    <td>Ripple</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Bcash</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ethereum</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lite</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="space"></div>
        <div class="ko-aus">
            <form action="">
                <label for="return">Amount spent: &nbsp</label>
                <input type="text" id="return" name="return">
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <label for="sell">Amount to sell: &nbsp</label>
                <input type="text" id="sell" name="sell">
            </form>
            <table>
                <tr>
                    <th>Coin</th>
                    <th>Profit</th>
                </tr>
                <tr>
                    <td>Ripple</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Bcash</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ethereum</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lite</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</body>
<script src="js/index.js"></script>
</html>

