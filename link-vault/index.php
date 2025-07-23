<!DOCTYPE html>
<html lang="en" class="transition duration-300">
<head>
    <meta charset="UTF-8">
    <title>LinkVault | Personal Link Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Enable dark mode class strategy
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition duration-300">

    <header class="bg-white dark:bg-gray-800 shadow p-6">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">🔗 LinkVault</h1>
            <div class="flex items-center gap-4">
                <button id="toggleDark" class="text-sm px-3 py-1 rounded border border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    🌓 Toggle Dark
                </button>
                <a href="auth/login.php" class="text-indigo-600 dark:text-indigo-300 hover:underline">Login</a>
                <a href="auth/register.php" class="bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
                    Sign Up
                </a>
            </div>
        </div>
    </header>

    <main class="mt-16 text-center max-w-3xl mx-auto">
        <h2 class="text-4xl font-extrabold mb-4">Your links. Organized.</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
            LinkVault helps you save, organize, and access your favorite links anytime, anywhere.
        </p>
        <a href="auth/register.php" class="bg-indigo-500 text-white px-6 py-3 rounded-full text-lg hover:bg-indigo-600 transition shadow">
            Get Started
        </a>
    </main>

    <footer class="mt-20 text-center text-gray-500 dark:text-gray-400 text-sm pb-6">
        &copy; <?= date('Y') ?> LinkVault. Built with 💙 in PHP.
    </footer>

    <script>
        const toggleBtn = document.getElementById('toggleDark');
        const html = document.documentElement;

        // Load saved mode
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
        }

        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    </script>

</body>
</html>