<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['name']) || empty($input['email']) || empty($input['password'])) {
    jsonResponse(['status' => 'error', 'message' => 'Semua field wajib diisi'], 400);
}

$name = trim($input['name']);
$email = trim($input['email']);
$password = $input['password'];

if (strlen($password) < 6) {
    jsonResponse(['status' => 'error', 'message' => 'Kata sandi minimal 6 karakter'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['status' => 'error', 'message' => 'Format email tidak valid'], 400);
}

$db = getDB();

$stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonResponse(['status' => 'error', 'message' => 'Email sudah terdaftar'], 409);
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare('INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())');
$stmt->execute([$name, $email, $hashedPassword]);

jsonResponse([
    'status' => 'success',
    'message' => 'Pendaftaran berhasil'
], 201);
