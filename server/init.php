<?php
require_once __DIR__ . '/config.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $db = getDB('users');
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
    echo "OK - users.db\n";

    $db = getDB('tokens');
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
    echo "OK - tokens.db\n";

    $db = getDB('gigs');
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
    echo "OK - gigs.db\n";

    echo "\nSemua database berhasil dibuat!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
