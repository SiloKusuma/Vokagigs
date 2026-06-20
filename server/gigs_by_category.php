<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['status' => 'error', 'message' => 'Method tidak diizinkan'], 405);
}

$category = $_GET['category'] ?? null;
if (!$category) {
    jsonResponse(['status' => 'error', 'message' => 'Kategori diperlukan'], 400);
}

$db = getDB('gigs');
$result = query($db, "SELECT * FROM gigs WHERE category = ? AND status = 'active' ORDER BY created_at DESC", [trim($category)]);
$gigs = fetchAll($result);

jsonResponse(['status' => 'success', 'gigs' => $gigs]);
