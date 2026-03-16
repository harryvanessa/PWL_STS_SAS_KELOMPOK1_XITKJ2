<?php
class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // Check if controller exists
        if( isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php') ) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check if method exists
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Setup params
        if( !empty($url) ) {
            $this->params = array_values($url);
        }

        // Run controller & method, sending params if any exist
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        $url = "";
        if( isset($_GET['url']) ) {
            $url = $_GET['url'];
        } else {
            // Fallback untuk PHP Built-in Server atau server tanpa .htaccess
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $scriptName = $_SERVER['SCRIPT_NAME'];
            
            // Hapus nama script jika ada di URI (misal: /index.php/auth)
            if (strpos($requestUri, $scriptName) === 0) {
                $url = substr($requestUri, strlen($scriptName));
            } else {
                // Hapus path folder jika project ada di subfolder
                $dir = str_replace('\\', '/', dirname($scriptName));
                if ($dir !== '/' && $dir !== '.') {
                    if (strpos($requestUri, $dir) === 0) {
                        $url = substr($requestUri, strlen($dir));
                    }
                } else {
                    $url = $requestUri;
                }
            }
        }

        if ($url) {
            $url = ltrim($url, '/');
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
