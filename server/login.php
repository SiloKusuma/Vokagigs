<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['email']) || empty($input['password'])) {
    jsonResponse(['status' => 'error', 'message' => 'Email dan kata sandi wajib diisi'], 400);
}

$email = trim($input['email']);
$password = $input['password'];

$db = getDB();
$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    jsonResponse(['status' => 'error', 'message' => 'Email atau kata sandi salah'], 401);
}

$token = generateToken();

$stmt = $db->prepare('INSERT INTO tokens (user_id, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY))');
$stmt->execute([$user['id'], $token]);

jsonResponse([
    'status' => 'success',
    'message' => 'Login berhasil',
    'token' => $token,
    'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ]
]);
