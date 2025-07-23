<?php
require '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$username || !$email || !$password) {
        $error = "All fields required.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        try {
            $stmt->execute([$username, $email, $hashed]);
            header("Location: login.php?registered=1");
            exit;
        } catch (PDOException $e) {
            $error = "Email already taken.";
        }
    }
}

ob_start();
?>

<div class="bg-gray-800 rounded-xl shadow-2xl p-8 w-full max-w-md">
  <h2 class="text-2xl font-bold mb-6 text-center">Register to LinkVault</h2>

  <?php if (!empty($error)): ?>
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">Register</button>
  </form>

  <p class="mt-4 text-sm text-center">Already have an account? <a href="login.php" class="text-blue-400 hover:underline">Login</a></p>
</div>

<?php
$content = ob_get_clean();
$title = "Register | LinkVault";
include '../components/layout.php';
?>