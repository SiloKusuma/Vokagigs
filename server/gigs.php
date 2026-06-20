<?php
require_once __DIR__ . '/config.php';

$token = getAuthorizationToken();
$user = validateToken($token);

if (!$user) {
    jsonResponse(['status' => 'error', 'message' => 'Token tidak valid atau sesi habis'], 401);
}

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['title']) || empty($input['description']) || empty($input['category']) || empty($input['price'])) {
        jsonResponse(['status' => 'error', 'message' => 'Semua field wajib diisi'], 400);
    }

    $stmt = $db->prepare('INSERT INTO gigs (user_id, title, description, category, price, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
    $stmt->execute([
        $user['id'],
        trim($input['title']),
        trim($input['description']),
        $input['category'],
        (int)$input['price'],
        'active'
    ]);

    $gigId = $db->lastInsertId();

    $stmt = $db->prepare('SELECT * FROM gigs WHERE id = ?');
    $stmt->execute([$gigId]);
    $gig = $stmt->fetch();

    jsonResponse([
        'status' => 'success',
        'message' => 'Gig berhasil dibuat',
        'gig' => $gig
    ], 201);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->prepare('SELECT * FROM gigs WHERE user_id = ? ORDER BY created_at DESC');
    $stmt->execute([$user['id']]);
    $gigs = $stmt->fetchAll();

    jsonResponse([
        'status' => 'success',
        'gigs' => $gigs
    ]);
}

jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
