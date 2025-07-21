<?php
session_start();
require_once '../db/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? 'all';

if ($month === 'all') {
    // View entries from the entire year based on entry_date
    $start = "$year-01-01";
    $end = "$year-12-31";

    $stmt = $db->prepare("
        SELECT entry_date, category, item_name, amount 
        FROM budget_entries 
        WHERE session_id IN (
            SELECT id FROM budget_sessions 
            WHERE user_id = ?
        )
        AND entry_date BETWEEN ? AND ?
        ORDER BY entry_date ASC
    ");
    $stmt->execute([$user_id, $start, $end]);
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // View entries for a specific month and year using entry_date
    $stmt = $db->prepare("
        SELECT entry_date, category, item_name, amount 
        FROM budget_entries 
        WHERE session_id IN (
            SELECT id FROM budget_sessions 
            WHERE user_id = ? AND month = ?
        )
        AND strftime('%Y', entry_date) = ?
        ORDER BY entry_date ASC
    ");
    $stmt->execute([$user_id, $month, $year]);
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total = array_sum(array_column($entries, 'amount'));
?>

<a href="dashboard.php">⬅ Back to Dashboard</a>
<h2>Viewing <?= $month === 'all' ? "All of $year" : "$month" ?> Entries</h2>

<?php if (count($entries) === 0): ?>
    <p>No entries found.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Item</th>
            <th>Amount (KES)</th>
        </tr>
        <?php foreach ($entries as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['entry_date']) ?></td>
                <td><?= htmlspecialchars($e['category']) ?></td>
                <td><?= htmlspecialchars($e['item_name']) ?></td>
                <td><?= number_format($e['amount'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total Spent</strong></td>
            <td><strong>KES <?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>
<?php endif; ?>