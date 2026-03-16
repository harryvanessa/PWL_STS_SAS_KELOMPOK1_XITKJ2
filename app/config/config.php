<?php
// Auto-detect BASEURL (Mendukung PHP Built-in Server & XAMPP/Laragon)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($path === '/' || $path === '\\') {
    $path = '';
} else {
    $path = rtrim($path, '/');
}
define('BASEURL', $protocol . '://' . $host . $path);

// DB Constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pwl_db');
