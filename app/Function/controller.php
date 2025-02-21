<?php
class Controller {

    // Load Model
    public function model($model) {
        $file = __DIR__ . "/../Models/" . ucfirst($model) . ".php";

        if (file_exists($file)) {
            require_once $file;
            return new $model();
        } else {
            die("❌ Model file not found: " . $file);
        }
    }

    // Load View
    public function view($view, $data = []) {
        $file = __DIR__ . "/../Views/" . $view . "/index.php";

        if (file_exists($file)) {
            require_once $file;
        } else {
            die("❌ View file not found: " . $file);
        }
    }
}
?>
