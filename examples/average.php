<?php

function average($arr) {
    if (count($arr) === 0) return 0;
    return round(array_sum($arr) / count($arr), 2);
}

$arrs = [
    "a" => [2, 4, 5, 7, 8, 14], 
    "b" => [3, 9, 89, 43, 92], 
    "c" => [42, 27, 83, 71], 
    "d" => [7, 9, 10]
];

foreach ($arrs as $key => $arr) {
    echo "<p>Average for set '$key' is " . average($arr) . " </p>";
}
?>