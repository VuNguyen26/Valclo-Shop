<?php
class UserController extends Controller {
    public function login($user, $array = "") {
        if (!isset($_SESSION["user"]) || $_SESSION["user"] == "customer") {
            $this->view("Login", ["key" => $array]);
        }
    }

    public function logout($user) {
        session_unset();
        $this->Home_page("customer");
    }

    public function update($user, $array) {
        if ($this->model($user)->update_user($array[2], $array[3], $array[4], $array[5])) {
            echo "ok";
        } else {
            echo "null";
        }
    }
}
?>
