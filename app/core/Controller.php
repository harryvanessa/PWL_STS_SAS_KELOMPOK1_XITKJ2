<?php

class Controller {
    public function __construct()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    // Render one or more views with shared $data
    public function view($view, $data = [])
    {
        $data['csrf_token'] = $_SESSION['csrf_token'];
        require_once '../app/views/' . $view . '.php';
    }

    // Render header + content + footer in one call
    public function render($view, $data = [])
    {
        $this->view('templates/header', $data);
        $this->view($view, $data);
        $this->view('templates/footer');
    }

    // Instantiate a model
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }

    // Redirect helper
    protected function redirect($path = '')
    {
        header('Location: ' . BASEURL . '/' . ltrim($path, '/'));
        exit;
    }

    // Check if current request is POST
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Validate CSRF token on POST
    protected function validateCsrf()
    {
        if ($this->isPost()) {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                session_destroy();
                die('+` Error: CSRF Token Invalid. Please reload the page.');
            }
        }
    }

    // Sanitize a single POST input
    protected function input($name)
    {
        return isset($_POST[$name]) ? htmlspecialchars(trim($_POST[$name])) : null;
    }

    // Flash + redirect in one line
    protected function flashRedirect($title, $message, $type, $path)
    {
        Flasher::setFlash($title, $message, $type);
        $this->redirect($path);
    }
}
