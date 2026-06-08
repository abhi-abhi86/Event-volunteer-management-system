<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['volunteer_id'])) {
    header('Location: volunteer_login.php');
    exit;
}

$volunteerId = (int)$_SESSION['volunteer_id'];
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

if ($eventId <= 0) {
    header('Location: events.php');
    exit;
}

$success = false;
$error = '';

try {
    // Prevent duplicates using the unique key (volunteer_id, event_id)
    $stmt = $pdo->prepare('INSERT INTO event_registrations (volunteer_id, event_id) VALUES (?, ?)');
    $stmt->execute([$volunteerId, $eventId]);
    $success = true;
} catch (PDOException $e) {
    // Duplicate entry (unique_registration)
    if ((int)$e->getCode() === 23000) {
        $error = 'You are already registered for this event.';
    } else {
        $error = 'Registration failed. Please try again.';
    }
}

// Avoid resubmission
header('Location: events.php?msg=' . ($success ? 'registered' : 'error') . '&error=' . urlencode($error));
exit;

