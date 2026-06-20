<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$token = getAuthorizationToken();
$user = validateToken($token);

if (!$user) {
    jsonResponse(['status' => 'error', 'message' => 'Token tidak valid atau sesi habis'], 401);
}

$db = getDB();

$stmt = $db->prepare('SELECT COUNT(*) as total FROM gigs WHERE user_id = ?');
$stmt->execute([$user['id']]);
$totalGigs = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as total FROM gigs WHERE user_id = ? AND status = 'completed'");
$stmt->execute([$user['id']]);
$completed = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as total FROM gigs WHERE user_id = ? AND status = 'active'");
$stmt->execute([$user['id']]);
$inProgress = $stmt->fetch()['total'];

$stmt = $db->prepare('SELECT COALESCE(SUM(price), 0) as total FROM gigs WHERE user_id = ? AND status = ?');
$stmt->execute([$user['id'], 'completed']);
$earnings = $stmt->fetch()['total'];

$stmt = $db->prepare('SELECT * FROM gigs WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$user['id']]);
$gigs = $stmt->fetchAll();

jsonResponse([
    'status' => 'success',
    'stats' => [
        'total_gigs' => (int)$totalGigs,
        'completed' => (int)$completed,
        'in_progress' => (int)$inProgress,
        'earnings' => (int)$earnings
    ],
    'gigs' => $gigs
]);
