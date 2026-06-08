<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, email, password FROM volunteers WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $vol = $stmt->fetch();

        if ($vol && password_verify($password, $vol['password'])) {
            $_SESSION['volunteer_id'] = (int)$vol['id'];
            header('Location: events.php');
            exit;
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Volunteer Login</title>
  <style>
    :root {
      --blue-dark: #0f1f4b;
      --blue-mid: #1d3f8f;
      --accent: #1ec7a0;
      --white: #ffffff;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      min-height: 100vh;
      background: #eef3ff;
      display: grid;
      place-items: center;
      padding: 24px;
    }
    .card {
      width: 100%;
      max-width: 520px;
      background: var(--white);
      border-radius: 16px;
      padding: 28px;
      box-shadow: 0 18px 35px rgba(13, 27, 61, 0.12);
    }
    h1 { color: var(--blue-dark); margin-bottom: 6px; font-size: 1.9rem; }
    p { color: #667796; margin-bottom: 18px; }
    label { display:block; margin-bottom:6px; color:#2a3f69; font-weight:700; }
    input {
      width:100%;
      border:1px solid #d5deef;
      border-radius:10px;
      padding:12px;
      margin-bottom:14px;
      font-size:1rem;
    }
    input:focus {
      outline:none;
      border-color: var(--blue-mid);
      box-shadow: 0 0 0 4px rgba(29,63,143,0.1);
    }
    .btn {
      width:100%;
      border:none;
      border-radius:10px;
      padding:12px;
      color:#fff;
      background: var(--accent);
      font-weight: bold;
      cursor:pointer;
      transition: transform .2s ease, box-shadow .2s ease;
      box-shadow: 0 12px 20px rgba(30,199,160,0.25);
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 14px 24px rgba(30,199,160,0.35); }
    .error {
      background:#ffe6e6;
      color:#b01b1b;
      border-radius:10px;
      padding:10px;
      margin-bottom:14px;
      font-size:.95rem;
    }
    .row { display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:space-between; }
    .link { color: var(--blue-mid); text-decoration: none; font-weight: 700; }
  </style>
</head>
<body>
  <form class="card" method="post" action="">
    <h1>Volunteer Login</h1>
    <p>Access your event registrations.</p>

    <?php if ($error !== ''): ?>
      <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required />

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required />

    <button class="btn" type="submit">Login</button>

    <div class="row" style="margin-top:14px;">
      <div>
        Don’t have an account? <a class="link" href="register.php">Register</a>
      </div>
      <div>
        <a class="link" href="index.php">Back to Home</a>
      </div>
    </div>
  </form>
</body>
</html>

