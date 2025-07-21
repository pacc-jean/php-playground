<?php

function convertToUSD($ksh){
    $exRate = 129.43;
    $usd = $ksh / $exRate;
    return round($usd, 2);
}

echo "<p>KSH 800 = USD " . convertToUSD(800) . " <br> </p>";
echo "<p>KSH 1200 = USD " . convertToUSD(1200) . " <br> </p>";
echo "<p>KSH 1600 = USD " . convertToUSD(1600) . " <br> </p>";
echo "<p>KSH 2000 = USD " . convertToUSD(2000) . " <br> </p>";
echo "<p>KSH 2400 = USD " . convertToUSD(2400) . " <br> </p>";
echo "<p>KSH 2800 = USD " . convertToUSD(2800) . " <br> </p>";
?>