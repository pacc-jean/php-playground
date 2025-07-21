<?php

function getPercentage($a, $b) {
    if ($b == 0) return "Undefined";
    return round(($a / $b) * 100, 2);
}

echo "<p>The percentage of 7200/12000 is ". getPercentage(7200, 12000) ." %</p>";
echo "<p>The percentage of 500/2000 is ". getPercentage(500, 2000) ." %</p>";
echo "<p>The percentage of 800/3000 is ". getPercentage(800, 3000) ." %</p>";
echo "<p>The percentage of 90000/400000 is ". getPercentage(90000, 400000) ." %</p>";
echo getPercentage(300, 0)
?>