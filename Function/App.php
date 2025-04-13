<?php
class App {
    protected $controller = "Home";
    protected $action = "Home_page";
    protected $params = [];

    function __construct() {
        $arr = $this->UrlProcess();

        // Controller
        if (!empty($arr) && file_exists("./Controller/" . $arr[0] . ".php")) {
            $this->controller = $arr[0];
            unset($arr[0]);
        }
        require_once("./Controller/" . $this->controller . ".php");
        $this->controller = new $this->controller;

        // Action
        if (isset($arr[1])) {
            if (method_exists($this->controller, $arr[1])) {
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }

        // Params: Add user type to params, and pass it with the rest of the parameters.
        if (isset($_SESSION["user"])) {
            array_push($this->params, $_SESSION["user"]);  // Add the user type (customer, member, manager)
        } else {
            $_SESSION["user"] = "customer"; // Default to customer if no session
            array_push($this->params, "customer");
        }

        // Add the rest of the parameters (e.g., product details) into params
        if (!empty($arr)) {
            array_push($this->params, $arr); // Pass the URL parameters
        }

        // Call the controller's method with the parameters
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function UrlProcess() {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
?>
