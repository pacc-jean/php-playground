<?php
session_start();
require_once '../db/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT id, name, month FROM budget_sessions WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group by Real Budget Year > Month
$grouped = [];

foreach ($sessions as $sesh) {
    $session_id = $sesh['id'];
    $month = $sesh['month'];

    // Fetch the earliest entry date for this session
    $entry_stmt = $db->prepare("SELECT entry_date FROM budget_entries WHERE session_id = ? ORDER BY entry_date ASC LIMIT 1");
    $entry_stmt->execute([$session_id]);
    $first_entry = $entry_stmt->fetch(PDO::FETCH_ASSOC);

    // Skip sessions with no entries
    if (!$first_entry) continue;

    $real_year = date('Y', strtotime($first_entry['entry_date']));

    if (!isset($grouped[$real_year])) $grouped[$real_year] = [];
    if (!in_array($month, $grouped[$real_year])) {
        $grouped[$real_year][] = $month;
    }
}
?>

<h2>Budget Sessions Dashboard</h2>
<a href="add_entry.php">Add New Entry</a><br><br>
<a href="../auth/logout.php">Logout</a>

<?php foreach ($grouped as $year => $months): ?>
    <h3><?= htmlspecialchars($year) ?></h3>
    <ul>
        <li><a href="view_session.php?year=<?= urlencode($year) ?>&month=all">View Full Year</a></li>
        <?php foreach ($months as $month): ?>
            <li>
                <a href="view_session.php?year=<?= urlencode($year) ?>&month=<?= urlencode($month) ?>">
                    <?= htmlspecialchars($month) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>