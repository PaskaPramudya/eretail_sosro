
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login_admin.php");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Ganti password ini dengan password pilihanmu.
$adminUsername = 'admin';
$adminPassword = 'SosroAdmin2026!';

if (
    hash_equals($adminUsername, $username) &&
    hash_equals($adminPassword, $password)
) {
    session_regenerate_id(true);
    $_SESSION['admin_login'] = true;
    $_SESSION['admin_username'] = $adminUsername;

    header("Location: admin.php");
    exit;
}

header("Location: login_admin.php?error=1");
exit;
?>
