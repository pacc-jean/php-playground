<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["clear"])) {
        // Clear all session data
        $_SESSION["budget"] = [];
    } else {
        $category = $_POST["category"];
        $amount = $_POST["amount"];

        // Simulated database
        session_start();
        if (!isset($_SESSION["budget"])) {
            $_SESSION["budget"] = [];
        }

        $_SESSION["budget"][] = [
            "category" => $category,
            "amount" => (float)$amount
        ];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Budget Summary</title>
</head>
<body>
    <h2>Budget Items</h2>
    <ul>
        <?php
        $total = 0;
        if (!empty($_SESSION["budget"])) {
            foreach ($_SESSION["budget"] as $item) {
                echo "<li>{$item['category']}: KSH {$item['amount']}</li>";
                $total += $item["amount"];
            }
            echo "<p><strong>Total:</strong> KSH $total</p>";
        } else {
            echo "<p>Nop items yet.</p>";
        }
        ?>
    </ul>
    
    <br><a href="index.php">← Back</a>
</body>
</html>