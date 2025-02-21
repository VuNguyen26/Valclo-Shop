<?php
class App {
    protected $controller = "Home";
    protected $action = "Home_page";
    protected $params = [];

    function __construct() {
        $arr = $this->UrlProcess();

        // Controller
        if (!empty($arr) && file_exists(__DIR__ . "/../Controller/" . $arr[0] . ".php")) {
            $this->controller = ucfirst($arr[0]);
            unset($arr[0]);
        }

        // Kiểm tra file có tồn tại trước khi require_once
        $file = __DIR__ . "/../Controller/" . $this->controller . ".php";
        if (!file_exists($file)) {
            die("File not found: " . $file);
        }
        require_once $file;
        $this->controller = new $this->controller;

        // Action
        if (isset($arr[1]) && method_exists($this->controller, $arr[1])) {
            $this->action = $arr[1];
            unset($arr[1]);
        }

        // Params
        $this->params = [];
        if (isset($_SESSION["user"])) {
            array_push($this->params, $_SESSION["user"]);
        } else {
            $_SESSION["user"] = "customer";
            array_push($this->params, "customer");
        }
        if (!empty($arr)) array_push($this->params, $arr);

        // Gọi controller và action
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess() {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
        return [];
    }
}
?>
