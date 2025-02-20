<?php
class CartController extends Controller {
    public function index($user) {
        if ($user == "member") {
            $mem = $this->model($user);
            $combo = $mem->get_order_combo($_SESSION["id"]);
            $product_in_combo = [];

            foreach ($combo as $cb) {
                $product_in_combo[] = [
                    "id" => $cb["id"],
                    "name" => $cb["name"],
                    "price" => $cb["price"],
                    "size" => $cb["size"],
                    "cycle" => mysqli_fetch_array($mem->get_cycle_id($cb["cycle"]))["cycle"],
                    "product" => $mem->get_product_in_combo($cb["cbid"])
                ];
            }

            $this->view("Cart", [
                "product_in_cart" => $mem->get_product_in_cart($_SESSION["id"]),
                "user" => mysqli_fetch_array($mem->get_user($_SESSION["id"])),
                "order_combo" => $product_in_combo
            ]);
        } else {
            $this->Login($user, "Cart");
        }
    }
}
?>
