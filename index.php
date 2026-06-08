<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Volunteer Management System</title>
    <style>
        :root {
            --primary: #0d1b3d;
            --secondary: #142b5f;
            --accent: #1ec7a0;
            --light: #f5f8ff;
            --text: #1f2a44;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 24px;
        }
        .hero {
            max-width: 920px;
            width: 100%;
            text-align: center;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 56px 36px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
        }
        h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            margin-bottom: 16px;
        }
        p {
            max-width: 700px;
            margin: 0 auto 34px;
            line-height: 1.7;
            font-size: 1.05rem;
        }
        .actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 26px;
            border-radius: 10px;
            color: #fff;
            background: var(--accent);
            font-weight: bold;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            box-shadow: 0 10px 20px rgba(30, 199, 160, 0.25);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 25px rgba(30, 199, 160, 0.35);
            background: #16ad8c;
        }
        .btn.secondary {
            background: #2f4da0;
            box-shadow: 0 10px 20px rgba(47, 77, 160, 0.3);
        }
        .btn.secondary:hover { background: #254089; }
    </style>
</head>
<body>
    <main class="hero">
        <h1>Event Volunteer Management System</h1>
        <p>
            Coordinate events efficiently with streamlined volunteer registration, event publishing, and easy admin access.
            Empower your team with a modern, centralized system for community engagement.
        </p>
        <div class="actions">
            <a class="btn" href="register.php">Volunteer Register</a>
            <a class="btn secondary" href="events.php">View Events</a>
            <a class="btn" href="admin_login.php">Admin Login</a>
        </div>
    </main>
</body>
</html>

