<?php
session_start();
require_once '../db/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entry_date = $_POST['entry_date'];
    $category = trim($_POST['category']);
    $item_name = trim($_POST['item_name']);
    $amount = floatval($_POST['amount']);
    $month = date('F Y', strtotime($entry_date));

    if (!$entry_date || !$category || !$item_name || !$amount) {
        $errors[] = "All fields are required.";
    } else {
        // Step 1: Check if session for this month exists
        $stmt = $db->prepare("SELECT id FROM budget_sessions WHERE user_id = ? AND month = ?");
        $stmt->execute([$user_id, $month]);
        $session = $stmt->fetch();

        // Step 2: Create session if not exists
        if (!$session) {
            $stmt = $db->prepare("INSERT INTO budget_sessions (user_id, name, month) VALUES (?, ?, ?)");
            $session_name = "Session for $month";
            $stmt->execute([$user_id, $session_name, $month]);
            $session_id = $db->lastInsertId();
        } else {
            $session_id = $session['id'];
        }

        // Step 3: Insert budget entry
        $stmt = $db->prepare("INSERT INTO budget_entries (session_id, entry_date, category, item_name, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$session_id, $entry_date, $category, $item_name, $amount]);

        $success = "Entry added!";
    }
}
?>

<h2>Add Budget Entry</h2>
<a href="dashboard.php">⬅Back to Dashboard</a>

<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    <label>Date:</label><br>
    <input type="date" name="entry_date" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category" required><br><br>

    <label>Item Name:</label><br>
    <input type="text" name="item_name" required><br><br>

    <label>Amount (KES):</label><br>
    <input type="number" step="0.01" name="amount" required><br><br>

    <button type="submit">Save Entry</button>
</form>