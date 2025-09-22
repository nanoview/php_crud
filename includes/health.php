<?php
header('Content-Type: application/json');
$ok = true;
$error = null;

// Attempt to include and connect
ob_start(); // suppress any accidental output prior to JSON
include __DIR__ . '/db_connect.php';
ob_end_clean();

// If we reached here, db_connect.php did not exit with error
try {
    // quick simple query
    $res = $conn->query('SELECT 1 as ok');
    if (!$res) {
        $ok = false;
        $error = 'Query failed';
    }
} catch (Throwable $t) {
    $ok = false;
    $error = 'Exception: ' . $t->getMessage();
}

echo json_encode([
    'status' => $ok ? 'ok' : 'error',
    'db' => $ok ? 'connected' : 'problem',
    'time' => date('c'),
    'host' => $_SERVER['SERVER_NAME'] ?? 'unknown',
    'error' => $error,
]);
exit;
