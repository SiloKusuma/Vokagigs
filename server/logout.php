<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$token = getAuthorizationToken();

if (!$token) {
    jsonResponse(['status' => 'error', 'message' => 'Token tidak ditemukan'], 400);
}

$db = getDB();
$stmt = $db->prepare('DELETE FROM tokens WHERE token = ?');
$stmt->execute([$token]);

jsonResponse([
    'status' => 'success',
    'message' => 'Logout berhasil'
]);
