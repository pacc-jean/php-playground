<!DOCTYPE html>
<html>
    <head>
        <title>Budget Tracker</title>
    </head>
    <body>
        <h2>My Budget Tracker</h2>
        <form action="process.php" method="POST">
            <label>Category:</label>
            <input type="text" name="category" required><br><br>

            <label>Amount (KSH):</label>
            <input type="number" name="amount" required><br><br>

            <button type="submit">Add to budget</button>
        </form>

        <br>

        <!-- Clear Entries Form -->
        <form action="process.php" method="POST">
            <input type="hidden" name="clear" value="1">
            <button type="submit" style="color: red;">Clear All Entries</button>
        </form>
    </body>
</html>