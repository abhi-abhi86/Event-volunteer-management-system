<?php
require_once 'db_connect.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $normalizedPhone = preg_replace('/[\s-]+/', '', $phone);
    $password = $_POST['password'] ?? '';

    if ($fullName === '' || $email === '' || $phone === '' || $password === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $normalizedPhone)) {
        $error = 'Please enter a valid phone number.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO volunteers (full_name, email, phone, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$fullName, $email, $normalizedPhone, $hashedPassword]);
            $message = 'Registration successful. You can now participate in events.';
        } catch (PDOException $e) {
            if (isset($e->errorInfo[0]) && $e->errorInfo[0] === '23000') {
                $error = 'This email is already registered.';
            } else {
                error_log('Volunteer registration failed: ' . $e->getMessage());
                $error = 'A system error occurred during registration. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration</title>
    <style>
        :root {
            --blue-dark: #0d1b3d;
            --blue-mid: #2d4da0;
            --accent: #1ec7a0;
            --bg: #eef3ff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #dfe9ff, #eef3ff);
            font-family: Arial, sans-serif;
            display: grid;
            place-items: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 16px 36px rgba(13, 27, 61, 0.13);
        }
        h1 { color: var(--blue-dark); margin-bottom: 6px; }
        .sub { color: #667796; margin-bottom: 22px; }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            color: #273b67;
        }
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
            box-shadow: 0 0 0 4px rgba(45, 77, 160, 0.12);
        }
        .btn {
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 20px rgba(30, 199, 160, 0.25);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(30, 199, 160, 0.35);
        }
        .msg, .err {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 14px;
            font-size: 0.95rem;
        }
        .msg { background: #e7fff7; color: #0f7f65; }
        .err { background: #ffe7e7; color: #ad1515; }
    </style>
</head>
<body>
    <form class="card" method="post" action="">
        <h1>Join as a Volunteer</h1>
        <p class="sub">Create your volunteer account in seconds.</p>

        <?php if ($message !== ''): ?>
            <div class="msg"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="err"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button class="btn" type="submit">Register</button>
    </form>
</body>
</html>
