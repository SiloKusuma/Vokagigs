<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$id = $_GET['id'] ?? null;
if (!$id) {
    jsonResponse(['status' => 'error', 'message' => 'ID diperlukan'], 400);
}

$db = getDB('gigs');
$result = query($db, 'SELECT * FROM gigs WHERE id = ?', [(int)$id]);
$gig = fetch($result);

if (!$gig) {
    jsonResponse(['status' => 'error', 'message' => 'Gig tidak ditemukan'], 404);
}

jsonResponse(['status' => 'success', 'gig' => $gig]);
