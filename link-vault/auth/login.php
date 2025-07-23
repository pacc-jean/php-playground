<?php
session_start();
require '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: /dashboard/dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}

$justRegistered = isset($_GET['registered']) ? true : false;

ob_start();
?>

<div class="bg-gray-800 rounded-xl shadow-2xl p-8 w-full max-w-md">
  <h2 class="text-2xl font-bold mb-6 text-center">Login to LinkVault</h2>

  <?php if ($justRegistered): ?>
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">Registration successful. You can now log in.</div>
  <?php endif; ?>

  <?php if (!empty($error)): ?>
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">Login</button>
  </form>

  <p class="mt-4 text-sm text-center">Don’t have an account? <a href="register.php" class="text-blue-400 hover:underline">Register</a></p>
</div>

<?php
$content = ob_get_clean();
$title = "Login | LinkVault";
include '../components/layout.php';
?>