<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
require_once 'db_connect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password FROM admins WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: events.php');
            exit;
        }

        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        :root {
            --blue-dark: #0f1f4b;
            --blue-mid: #1d3f8f;
            --white: #ffffff;
            --accent: #1ec7a0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: #eef3ff;
        }
        .layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .image-side {
            background-image: linear-gradient(rgba(15, 31, 75, 0.55), rgba(29, 63, 143, 0.6)), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        .form-side {
            display: grid;
            place-items: center;
            padding: 24px;
            background: #f8faff;
        }
        .card {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 18px 35px rgba(13, 27, 61, 0.12);
        }
        h1 {
            color: var(--blue-dark);
            margin-bottom: 8px;
            font-size: 1.9rem;
        }
        p.note { color: #60708f; margin-bottom: 22px; }
        label { display: block; margin-bottom: 6px; color: #2a3f69; font-weight: 700; }
        input {
            width: 100%;
            border: 1px solid #d5deef;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 16px;
            font-size: 1rem;
        }
        input:focus {
            outline: none;
            border-color: var(--blue-mid);
            box-shadow: 0 0 0 4px rgba(29, 63, 143, 0.1);
        }
        .btn {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: #fff;
            background: var(--accent);
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 20px rgba(30, 199, 160, 0.25);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(30, 199, 160, 0.35);
        }
        .error {
            background: #ffe6e6;
            color: #b01b1b;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 14px;
            font-size: 0.95rem;
        }
        @media (max-width: 860px) {
            .layout { grid-template-columns: 1fr; }
            .image-side { min-height: 34vh; }
        }
    </style>
</head>
<body>
    <main class="layout">
        <section class="image-side" aria-label="Volunteers helping community"></section>
        <section class="form-side">
            <form class="card" method="post" action="">
                <h1>Welcome Back</h1>
                <p class="note">Admin portal access</p>

                <?php if ($error !== ''): ?>
                    <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>

                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button class="btn" type="submit">Login</button>
            </form>
        </section>
    </main>
</body>
</html>
