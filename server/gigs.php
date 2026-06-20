<?php
require_once __DIR__ . '/config.php';

$token = getAuthorizationToken();
$user = validateToken($token);

if (!$user) {
    jsonResponse(['status' => 'error', 'message' => 'Token tidak valid atau sesi habis'], 401);
}

$db = getDB('gigs');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['title']) || empty($input['description']) || empty($input['category']) || empty($input['price'])) {
        jsonResponse(['status' => 'error', 'message' => 'Semua field wajib diisi'], 400);
    }

    query($db, "INSERT INTO gigs (user_id, title, description, category, price, status, created_at) VALUES (?, ?, ?, ?, ?, ?, datetime('now'))", [
        $user['id'],
        trim($input['title']),
        trim($input['description']),
        $input['category'],
        (int)$input['price'],
        'active'
    ]);

    $gigId = $db->lastInsertRowID();

    $result = query($db, 'SELECT * FROM gigs WHERE id = ?', [$gigId]);
    $gig = fetch($result);

    jsonResponse([
        'status' => 'success',
        'message' => 'Gig berhasil dibuat',
        'gig' => $gig
    ], 201);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = query($db, 'SELECT * FROM gigs WHERE user_id = ? ORDER BY created_at DESC', [$user['id']]);
    $gigs = fetchAll($result);

    jsonResponse([
        'status' => 'success',
        'gigs' => $gigs
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['id'])) {
        jsonResponse(['status' => 'error', 'message' => 'ID gig diperlukan'], 400);
    }

    $result = query($db, 'SELECT * FROM gigs WHERE id = ? AND user_id = ?', [$input['id'], $user['id']]);
    $gig = fetch($result);
    if (!$gig) {
        jsonResponse(['status' => 'error', 'message' => 'Gig tidak ditemukan'], 404);
    }

    $fields = [];
    $params = [];

    if (!empty($input['title'])) {
        $fields[] = 'title = ?';
        $params[] = trim($input['title']);
    }
    if (!empty($input['description'])) {
        $fields[] = 'description = ?';
        $params[] = trim($input['description']);
    }
    if (!empty($input['category'])) {
        $fields[] = 'category = ?';
        $params[] = $input['category'];
    }
    if (isset($input['price'])) {
        $fields[] = 'price = ?';
        $params[] = (int)$input['price'];
    }
    if (!empty($input['status'])) {
        $fields[] = 'status = ?';
        $params[] = $input['status'];
    }

    if (empty($fields)) {
        jsonResponse(['status' => 'error', 'message' => 'Tidak ada data yang diubah'], 400);
    }

    $params[] = $input['id'];
    $params[] = $user['id'];

    query($db, 'UPDATE gigs SET ' . implode(', ', $fields) . ' WHERE id = ? AND user_id = ?', $params);

    $result = query($db, 'SELECT * FROM gigs WHERE id = ?', [$input['id']]);
    $gig = fetch($result);

    jsonResponse([
        'status' => 'success',
        'message' => 'Gig berhasil diperbarui',
        'gig' => $gig
    ]);
}

jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
