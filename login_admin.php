
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin Sosro</title>
    <style>
        body { font-family: Arial; background: #f3f3f3; }
        .login {
            width: 320px; margin: 100px auto; padding: 25px;
            background: white; border-radius: 10px;
        }
        input, button {
            width: 100%; padding: 11px; margin: 8px 0;
            box-sizing: border-box;
        }
        button { background: #b51f24; color: white; border: 0; }
    </style>
</head>
<body>
<div class="login">
    <h2>Login Admin Sosro</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red">Username atau password salah!</p>
    <?php endif; ?>

    <form action="proses_login_admin.php" method="POST">
        <input type="text" name="username"
               placeholder="Username admin" required>
        <input type="password" name="password"
               placeholder="Password admin" required>
        <button type="submit">Login</button>
    </form>

    <a href="pelanggan.html">Kembali ke toko</a>
</div>
</body>
</html>
