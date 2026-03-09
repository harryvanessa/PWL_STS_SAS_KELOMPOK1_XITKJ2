<?php

class Controller {
    public function __construct()
    {
        // Generate CSRF token if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public function view($view, $data = [])
    {
        // Add CSRF token to all views data
        $data['csrf_token'] = $_SESSION['csrf_token'];
        require_once '../app/views/' . $view . '.php';
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }

    /**
     * CSRF Protection
     */
    protected function validateCsrf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                // Potential CSRF attack
                session_destroy();
                die("Security Error: CSRF Token Invalid atau Expired. Coba memuat ulang halaman.");
            }
        }
    }

    /**
     * XSS Cleaning
     */
    protected function input($name)
    {
        if (isset($_POST[$name])) {
            return htmlspecialchars(trim($_POST[$name]));
        }
        return null;
    }
}
