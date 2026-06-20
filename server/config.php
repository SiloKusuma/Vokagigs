<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

define('DB_PATH', __DIR__ . '/data');

function getDB($name) {
    if (!is_dir(DB_PATH)) {
        mkdir(DB_PATH, 0755, true);
    }
    $path = DB_PATH . '/' . $name . '.db';
    try {
        $db = new SQLite3($path);
        $db->enableExceptions(true);
        $db->exec('PRAGMA journal_mode=WAL');
        $db->exec('PRAGMA foreign_keys=ON');
        initDB($db, $name);
        return $db;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Koneksi database gagal'
        ]);
        exit();
    }
}

function initDB($db, $name) {
    static $initialized = [];
    if (isset($initialized[$name])) return;
    $initialized[$name] = true;

    switch ($name) {
        case 'users':
            $db->exec('
                CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    created_at TEXT DEFAULT (datetime(\'now\'))
                )
            ');
            $db->exec('CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)');
            break;
        case 'tokens':
            $db->exec('
                CREATE TABLE IF NOT EXISTS tokens (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    token TEXT NOT NULL UNIQUE,
                    expires_at TEXT NOT NULL,
                    created_at TEXT DEFAULT (datetime(\'now\'))
                )
            ');
            $db->exec('CREATE INDEX IF NOT EXISTS idx_tokens_token ON tokens(token)');
            $db->exec('CREATE INDEX IF NOT EXISTS idx_tokens_expires ON tokens(expires_at)');
            break;
        case 'gigs':
            $db->exec('
                CREATE TABLE IF NOT EXISTS gigs (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    title TEXT NOT NULL,
                    description TEXT NOT NULL,
                    category TEXT NOT NULL,
                    price INTEGER NOT NULL,
                    status TEXT DEFAULT \'active\',
                    created_at TEXT DEFAULT (datetime(\'now\'))
                )
            ');
            $db->exec('CREATE INDEX IF NOT EXISTS idx_gigs_user ON gigs(user_id)');
            $db->exec('CREATE INDEX IF NOT EXISTS idx_gigs_status ON gigs(status)');
            break;
    }
}

function query($db, $sql, $params = []) {
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        throw new Exception($db->lastErrorMsg());
    }
    foreach ($params as $i => $param) {
        $type = SQLITE3_TEXT;
        if (is_int($param)) $type = SQLITE3_INTEGER;
        elseif (is_float($param)) $type = SQLITE3_FLOAT;
        elseif (is_null($param)) $type = SQLITE3_NULL;
        $stmt->bindValue($i + 1, $param, $type);
    }
    $result = $stmt->execute();
    if (!$result) {
        throw new Exception($db->lastErrorMsg());
    }
    return $result;
}

function fetch($result) {
    return $result ? $result->fetchArray(SQLITE3_ASSOC) : false;
}

function fetchAll($result) {
    $rows = [];
    if ($result) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function generateToken($length = 64) {
    return bin2hex(random_bytes($length / 2));
}

function getAuthorizationToken() {
    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    if (strpos($auth, 'Bearer ') === 0) {
        return substr($auth, 7);
    }
    return null;
}

function validateToken($token) {
    if (!$token) return false;

    $db = getDB('tokens');
    $result = query($db, "SELECT user_id FROM tokens WHERE token = ? AND expires_at > datetime('now')", [$token]);
    $row = fetch($result);
    if (!$row) return false;

    $db = getDB('users');
    $result = query($db, 'SELECT * FROM users WHERE id = ?', [$row['user_id']]);
    return fetch($result);
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit();
}
