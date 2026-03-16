<?php

class Flasher {
    public static function setFlash($title, $message, $type = 'success')
    {
        $_SESSION['flash'] = compact('title', 'message', 'type');
    }

    public static function flash()
    {
        if (!isset($_SESSION['flash'])) return;

        ['title' => $t, 'message' => $m, 'type' => $tp] = $_SESSION['flash'];
        unset($_SESSION['flash']);

        echo <<<HTML
        <div class="alert alert-{$tp} alert-dismissible fade show" role="alert">
            <strong>{$t}</strong> {$m}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
    }

    public static function rawFlash()
    {
        if (!isset($_SESSION['flash'])) return false;
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
}
