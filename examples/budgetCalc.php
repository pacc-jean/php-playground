<?php

function calculateTotalExpenses($expenses) {
    return array_sum($expenses);
}

function calculateSavings($income, $totalExpenses) {
    return $income - $totalExpenses;
}

function getSavingsFeedback($savings, $income) {
    $savingPercent = round(($savings / $income) * 100, 2);

    if ($savings < 0) {
        return "<p style='color: red;'>You're in the red.</p>";
    } elseif ($savings < 10000) {
        return "<p style='color: orange;'>You’re scraping by.</p>";
    } else {
        return "<p style='color: green;'>Saving $savingPercent%. Keep it up!</p>";
    }
}

// Inputs
$income = 75000;
$expenses = [
    "Rent" => 20000,
    "Food" => 10000,
    "Transport" => 5000,
    "Internet" => 2500,
    "Subs" => 1500,
    "Savings" => 15000
];

// Process
$total = calculateTotalExpenses($expenses);
$savings = calculateSavings($income, $total);
$feedback = getSavingsFeedback($savings, $income);

// Output
echo "<h2>Kenpro Budget</h2>";
echo "<p>Income: Ksh $income</p>";
echo "<p>Total Expenses: Ksh $total</p>";
echo "<p>Savings: Ksh $savings</p>";
echo $feedback;

?>