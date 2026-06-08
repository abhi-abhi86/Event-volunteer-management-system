<?php
session_start();
require_once 'db_connect.php';

$volunteerId = isset($_SESSION['volunteer_id']) ? (int)$_SESSION['volunteer_id'] : 0;

$stmt = $pdo->query('SELECT id, title, description, event_date, location FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC');
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        :root {
            --blue-dark: #0d1b3d;
            --blue-mid: #2d4da0;
            --accent: #1ec7a0;
            --card: #ffffff;
            --bg: #edf3ff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: #253354;
            min-height: 100vh;
            padding: 34px 20px;
        }
        .wrap { max-width: 1100px; margin: 0 auto; }
        h1 {
            color: var(--blue-dark);
            margin-bottom: 10px;
            text-align: center;
        }
        .intro {
            text-align: center;
            color: #5b6d90;
            margin-bottom: 26px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }
        .card {
            background: var(--card);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 14px 30px rgba(13, 27, 61, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e2e8f7;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px rgba(13, 27, 61, 0.14);
        }
        .title {
            color: var(--blue-dark);
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.93rem;
            color: #304979;
            font-weight: 700;
        }
        .desc { color: #4a5d84; line-height: 1.6; }
        .empty {
            text-align: center;
            background: #fff;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 12px 24px rgba(13, 27, 61, 0.1);
        }
        .back {
            display:inline-block;
            text-decoration:none;
            padding:10px 16px;
            border-radius:10px;
            color:#fff;
            font-weight:800;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 10px 20px rgba(13, 27, 61, 0.08);
        }
        .back:hover { transform: translateY(-2px); }

    </style>
</head>
<body>
<main class="wrap">
        <h1>Upcoming Events</h1>
        <p class="intro">Discover where your support can make the biggest difference.</p>
        <div class="topbar" style="text-align:center; margin-bottom:18px;">
            <?php if ($volunteerId > 0): ?>
                <span style="color:#2d4da0; font-weight:800;">Logged in</span>
                <a class="back" href="logout.php" style="margin-left:12px; background:#0d1b3d;">Logout</a>
            <?php else: ?>
                <a class="back" href="volunteer_login.php" style="background:#0d1b3d;">Volunteer Login</a>
            <?php endif; ?>
            <a class="back" href="register.php" style="margin-left:12px; background:#1ec7a0;">Register</a>
        </div>


        <?php if (count($events) > 0): ?>
            <section class="grid">
                <?php foreach ($events as $event): ?>
<article class="card">
                        <h2 class="title"><?php echo htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <div class="meta">
                            <span>Date: <?php echo htmlspecialchars(date('d M Y', strtotime($event['event_date'])), ENT_QUOTES, 'UTF-8'); ?></span>
                            <span>Location: <?php echo htmlspecialchars($event['location'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <p class="desc"><?php echo nl2br(htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8')); ?></p>

                        <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:space-between;">
                            <a class="back" href="volunteer_login.php" style="background:#2d4da0;">Login to Register</a>
                            <a class="back" href="register_event.php?event_id=<?php echo (int)$event['id']; ?>" style="background:#1ec7a0;">Register</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div class="empty">No upcoming events found. Please check back soon.</div>
        <?php endif; ?>
    </main>
</body>
</html>

