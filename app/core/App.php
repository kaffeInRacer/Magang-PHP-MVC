<?php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        // Parse URL
        $url = $this->parseURL();

        // Admin route handling
        if ($url !== null && $url[0] === 'admin') {
            $adminController = $this->loadAdminController($url);
            $this->controller = $adminController['controller'];
            $this->method = $adminController['method'];
            $this->params = $adminController['params'];
        } else {
            // Non-admin route handling
            $nonAdminController = $this->loadNonAdminController($url);
            $this->controller = $nonAdminController['controller'];
            $this->method = $nonAdminController['method'];
            $this->params = $nonAdminController['params'];
        }

        // Execute the controller method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function loadAdminController($url)
    {
        $defaultController = 'DashboardController';

        if (isset($url[1]) && !empty($url[1]) && file_exists('app/controllers/admin/' . ucfirst($url[1]) . 'Controller.php')) {
            $controllerClassName = ucfirst($url[1]) . 'Controller';
            $method = isset($url[2]) ? strtolower($url[2]) : 'index';
            $params = array_slice($url, 3);
        } else {
            $controllerClassName = $defaultController;
            $method = 'index';
            $params = [];
        }

        require_once 'app/controllers/admin/' . $controllerClassName . '.php';
        $controllerInstance = new $controllerClassName;

        return ['controller' => $controllerInstance, 'method' => $method, 'params' => $params];
    }

    protected function loadNonAdminController($url)
    {
        $defaultController = 'HomeController';

        $getURL = $url === null ? "" : $url[0] . 'Controller';
        if (file_exists('app/controllers/' . ucfirst($getURL) . '.php')) {
            $controllerClassName = ucfirst($getURL);
            $method = isset($url[1]) ? strtolower($url[1]) : 'index';
            $params = array_slice($url, 2);

            require_once 'app/controllers/' . $controllerClassName . '.php';
            $controllerInstance = new $controllerClassName;

            return ['controller' => $controllerInstance, 'method' => $method, 'params' => $params];
        } else {
            // Jika controller tidak ditemukan, gunakan default dan metode 'index'
            $controllerClassName = $defaultController;
            $method = 'index';
            $params = [];

            require_once 'app/controllers/' . $controllerClassName . '.php';
            $controllerInstance = new $controllerClassName;

            return ['controller' => $controllerInstance, 'method' => $method, 'params' => $params];
        }
    }


    function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET["url"], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return null;
    }
}
