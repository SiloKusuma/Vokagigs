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

$db = getDB('gigs');

$result = query($db, 'SELECT COUNT(*) as total FROM gigs WHERE user_id = ?', [$user['id']]);
$totalGigs = fetch($result)['total'];

$result = query($db, "SELECT COUNT(*) as total FROM gigs WHERE user_id = ? AND status = 'completed'", [$user['id']]);
$completed = fetch($result)['total'];

$result = query($db, "SELECT COUNT(*) as total FROM gigs WHERE user_id = ? AND status = 'active'", [$user['id']]);
$inProgress = fetch($result)['total'];

$result = query($db, 'SELECT COALESCE(SUM(price), 0) as total FROM gigs WHERE user_id = ? AND status = ?', [$user['id'], 'completed']);
$earnings = fetch($result)['total'];

$result = query($db, 'SELECT * FROM gigs WHERE user_id = ? ORDER BY created_at DESC', [$user['id']]);
$gigs = fetchAll($result);

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
