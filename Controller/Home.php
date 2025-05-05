<?php

class Home extends Controller{
        function Home_page($user){
            $cus = $this->model($user);
            $news = $cus->get_news();
            $news_list = array();
            foreach($news as $snews){
                array_push($news_list, ([
                    "id" => $snews["id"],
                    "cid" => $snews["cid"],
                    "key" => $snews["key"], 
                    "time" => $snews["time"],
                    "title" => $snews["title"],
                    "content" => $snews["content"],
                    "imgurl" => $snews["img_url"],
                    "shortcontent" => $snews["short_content"],
                    "comment" => $cus->get_comment_news($snews["id"])]));
            }
            $this->view("Home_page", [
                "user" => $user,
                "news" => $news_list,
                "collection" => $cus->get_products("collection", "", 1, "", "all")["list"],
                "featured" => $cus->get_products("featured", "", 1, "", "all")["list"]
            ]);
        }
        function About_us($user){
            $this->view("About_US", []);
        }
        function Products($user, $sort_1 = "", $sort_2 = "") {
            $cus = $this->model($user);
        
            $sort_by = $_GET['sort-by'] ?? null;
            $order_by = $_GET['order-by'] ?? null;
            $page = $_GET['page'] ?? 1;
            $search = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? 'all';
        
            // ✅ Tách giá trị từ dropdown "price-range"
            $price_min = 0;
            $price_max = 999999999;
            if (isset($_GET['price-range']) && $_GET['price-range'] !== '') {
                $range = explode('-', $_GET['price-range']);
                $price_min = isset($range[0]) ? intval($range[0]) : 0;
                $price_max = (isset($range[1]) && $range[1] !== '') ? intval($range[1]) : 999999999;
            }
        
            $this->view("Products", [
                "cate" => $cus->get_product_cates(),
                "product" => $cus->get_products(
                    $sort_by,
                    $order_by,
                    $page,
                    $search,
                    $category,
                    $price_min,
                    $price_max
                ),
                "user" => $user
            ]);
        }
        
                
        
        function Item($user, $pid){
            $cus = $this->model($user);
            $comment = $cus->get_item_comment($pid[2], "");
            $cmt_info = array();
            foreach($comment as $cmt){
                array_push($cmt_info, (["id" => $cmt["id"], "pid" => $cmt["pid"], "uid" => $cmt["uid"], "uname" => $cus->get_cmt_user_name($cmt["uid"]), "star" => $cmt["star"], "content" => $cmt["content"], "time" => $cmt["time"]]));
            }
            $this->view("Item", [
                "product_id" => $cus->get_product_at_id($pid[2]),
                "sub_img" => $cus->get_sub_img($pid[2]),
                "cate_product" => $cus->get_product_same_cate($pid[2]),
                "comment" => $cmt_info,
                "user" => $user
            ]);
        }

        function Contact_us($user){
            if($user == "manager"){
                $this->view("Contact_US", [
                    "user" => $user,
                    "message" => $this->model($user)->get_message()
                ]);
            }
            else{
                $this->view("Contact_US", [
                    "user" => $user
                ]);
            }
        }

        function News($user){
            $cus = $this->model($user);
            $news = $cus->get_news();
            $news_list = array();
            foreach($news as $snews){
                array_push($news_list, ([
                    "id" => $snews["id"],
                    "cid" => $snews["cid"],
                    "key" => $snews["key"], 
                    "time" => $snews["time"],
                    "title" => $snews["title"],
                    "content" => $snews["content"],
                    "imgurl" => $snews["img_url"],
                    "shortcontent" => $snews["short_content"]]));
            }
            $this->view("News", [
                "news" => $news_list,
                "user" => $user
            ]);
        }
        
        function News_detail($user, $params){
            $cus = $this->model($user);
            $news = $cus->get_news();
            $news_list = array();
            foreach($news as $snews){
                array_push($news_list, ([
                    "id" => $snews["id"],
                    "cid" => $snews["cid"],
                    "key" => $snews["key"], 
                    "time" => $snews["time"],
                    "title" => $snews["title"],
                    "content" => $snews["content"],
                    "imgurl" => $snews["img_url"],
                    "shortcontent" => $snews["short_content"],
                    "comment" => $cus->get_comment_news($snews["id"])]));
            }   
            $this->view("News_detail", [
                "news" => $news_list,
                "user" => $user,
                "params"=> $params[2]
            ]);
        }

        function Post_news($user, $params){
            if((int)$params[2] !== -1){
                $cus = $this->model($user);
                $news = $cus->get_news_by_nid((int)$params[2]);
                $news_list = array();
                foreach($news as $snews){
                    array_push($news_list, ([
                        "id" => $snews["id"],
                        "cid" => $snews["cid"],
                        "key" => $snews["key"], 
                        "time" => $snews["time"],
                        "title" => $snews["title"],
                        "content" => $snews["content"],
                        "imgurl" => $snews["img_url"],
                        "shortcontent" => $snews["short_content"]]));
                }   
                $this->view("Post_news", [
                    "news" => $news_list,
                    "user" => $user,
                    "params"=> $params[2]
                ]);
                $this->view("Post_news", []);
            }
            else {
                $cus = $this->model($user);
                $news_list = array();
                array_push($news_list, ([
                    "id" => "",
                    "cid" => "",
                    "key" => "", 
                    "time" => "",
                    "title" => "",
                    "content" => "",
                    "imgurl" => "",
                    "shortcontent" => "" ]));
                $this->view("Post_news", [
                    "news" => $news_list,
                    "user" => $user,
                    "params"=> $params[2]
                ]);
                $this->view("Post_news", []);
            }
        }
        function delete_news($user, $id){
            echo (int)$id[2];
            $this->model($user)->delete_news((int)$id[2]);
        }

        function add_comment_news($user, $array){
            $this->model($user)->add_comment_news($array[2], $array[3], $_SESSION["id"]);
        }

        function insert_news($user){
            if(isset($_POST["key"]) && isset($_POST["title"]) && isset($_POST["url"]) && isset($_POST["content"]) && isset($_POST["shortcontent"]))
            {
                if(isset($_FILES["e-image-url"])){
                    if($_FILES['e-image-url']['name'][0] != ""){
                        if(!file_exists("./Views/images/" . $_FILES["e-image-url"]['name'][0])){
                            move_uploaded_file($_FILES['e-image-url']['tmp_name'][0], './Views/images/' . $_FILES['e-image-url']['name'][0]);
                        }
                        if((int)$_POST["url"] != -1){
                            $this->model($user)->update_news((int)$_POST["url"], $_POST["key"], $_POST["title"], $_POST["content"], './Views/images/' . $_FILES['e-image-url']['name'][0], $_POST["shortcontent"]);
                        }
                        else{
                            $this->model($user)->insert_news($_POST["key"], $_POST["title"], $_POST["content"], './Views/images/' . $_FILES['e-image-url']['name'][0], $_POST["shortcontent"]);
                        }
                        
                    }
                    
                }
            }
            $this->News($user);
        }

        function Cart($user){
            if($user == "member"){
                $mem = $this->model($user);
                $this->view("Cart", [
                    "product_in_cart" => $mem->get_product_in_cart($_SESSION["id"]),
                    "user" => mysqli_fetch_array($mem->get_user($_SESSION["id"])),
                ]);
            }
            else{
                $this->Login($user, "Cart");
            }
        }
        function Login($user, $array=""){
            if(!isset($_SESSION["user"]) || $_SESSION["user"] == "customer")
                $this->view("Login", ["key" => $array]);
        }
        function Payment($user){
            if($user == "member"){
                $mem = $this->model($user);
                $this->view("Payment", [
                    "product_in_cart" => $mem-> get_product_in_cart($_SESSION["id"]),
                ]);
            }
            else{
                $this->Login($user, "Payment");
            }
        }
        function forgot($user){
            $this->view("forgot", []);
        }
        function register($user){
            $this->view("register", []);
        }
        function insert_message($user, $array){
            if($this->model($user)->insert_message($array[2], $array[3], $array[4], $array[5], $array[6])) echo "ok";
            else echo "null";
        }
        public function update_user($user) {
            $input = json_decode(file_get_contents("php://input"), true);
        
            if (!$input || !isset($_SESSION["id"])) {
                echo "null";
                return;
            }
        
            $id = intval($input["id"]);
            $fname = $input["name"];
            $phone = $input["phone"];
            $addr = $input["address"];
        
            if ($this->model($user)->update_user($id, $fname, $phone, $addr)) {
                $_SESSION["address_from_db"] = $addr;
                echo "ok";
            } else {
                echo "null";
            }
        }
        
        function delete_product_incart($user, $array){
            if($this->model($user)->delete_product_incart((int)$array[2])) echo "ok";
            else echo "null";
        }
        
        function check_login($user, $array) {
            if (isset($array[2]) && isset($array[3]) && $array[2] == "admin" && $array[3] == "admin") {
                $_SESSION["user"] = "manager";
                $redirect = isset($array[4]) ? $array[4] : "Home_page";
                echo "?url=/Home/" . $redirect . "/";
            } 
            else if (isset($array[2]) && isset($array[3])) {
                $loginResult = $this->model("member")->login($array[2], $array[3]);
        
                if (!$loginResult['success']) {
                    echo "error:" . $loginResult['message'];
                } else {
                    $_SESSION["id"] = $loginResult["user"]["ID"];
                    $_SESSION["user"] = "member";
                    $redirect = isset($array[4]) ? $array[4] : "Home_page";
                    echo "?url=/Home/" . $redirect . "/";
                }
            } 
            else {
                echo "null";
            }
        }        
        
        function update_product_in_cart($user, $array){
            $action = $this->model($user);
            for($i = 0; $i < (int)$array[2]; $i++){
                $action->update_product_in_cart((int)$array[2 + 3*$i + 1], (int)$array[2 + 3*$i +2], $array[2 + 3*$i + 3]);
            }
            echo "?url=/Home/Payment/";
        }

        function update_cart($user, $params) {
            $mem = $this->model($user);
            $oid = (int)$params[2];
            $mem->update_cart($oid);
        }
        
        function order_detail($user, $params) {
            if ($user === "member") {
                $mem = $this->model($user);
                if (isset($params[2]) && ctype_digit($params[2])) {
                    $oid = (int)$params[2];
                } elseif (isset($_GET['oids']) && ctype_digit($_GET['oids'])) {
                    $oid = (int)$_GET['oids'];
                } else {
                    die("Thiếu mã đơn hàng để hiển thị chi tiết.");
                }
                $order_items = $mem->get_product_in_order_detail($oid);

                $order_meta = mysqli_fetch_assoc(
                    $mem->get_order_by_id($oid)
                );
                $order_info = [
                    "id"     => $oid,
                    "items"  => $order_items,
                    "state"  => $order_meta["state"]  ?? 0,
                    "time"   => $order_meta["time"]   ?? "Không rõ",
                    "total"  => $order_meta["total"]  ?? 0,
                    "method"  => $order_meta["method"]  ?? 'Không có'
                ];
                $this->view("OrderDetail", [
                    "order" => $order_info,
                    "user"  => $mem->get_user($_SESSION["id"])
                ]);
            } else {
                $this->Login($user, "order_detail");
            }
        }
    
        function member_page($user){
            if ($user == "member") {
                $mem = $this->model($user);
                $cartid = $mem->get_cart($_SESSION["id"]);
        
                if ($cartid && is_array($cartid)) {
                    $product_in_cart = array();
                    foreach ($cartid as $id) {
                        array_push($product_in_cart, [
                            "cartid" => $id,
                            "product" => $mem->get_product_in_cart_mem((int)$id["id"])
                        ]);
                    }
                } else {
                    $product_in_cart = [];
                }
                $orders = $mem->get_orders($_SESSION["id"]);
                $this->view("Memberpage", [
                    "user" => $mem->get_user($_SESSION["id"]),
                    "product_in_cart" => $product_in_cart,
                    "orders" => $orders,
                    "state" => $user
                ]);
            }
            else if ($user == "manager") {
                $this->view("Memberpage", [
                    "state" => $user,
                    "member" => $this->model($user)->get_all_user_info()
                ]);
            } else {
                $this->Login($user, "member_page");
            }
        }
        
        public function reorder($id) {
            if (!isset($_SESSION["id"])) die("Vui lòng đăng nhập");
            $uid = $_SESSION["id"];
            $mem = $this->model("member");
            $new_oid = $mem->reorder($id, $uid);
            header("Location: ?url=Home/Products");
        }
        
        function add_item_comment($user, $array){
            $this->model($user)->add_item_comment($array[2], $array[3], $array[4], $_SESSION["id"]);
        }

        function update_profile($user){
            if( isset($_POST["fname"]) && isset($_POST["mail"]) && isset($_POST["username"]) && isset($_POST["cmnd"]) && isset($_POST["phone"]) && isset($_POST["address"]))
            {
                if(isset($_FILES["file_pic"])&& $_FILES["file_pic"]['name'] != ""){
                    if(!file_exists("./Views/images/" . $_FILES["file_pic"]['name']))
                        move_uploaded_file($_FILES['file_pic']['tmp_name'], './Views/images/' . $_FILES['file_pic']['name']);
                    $this->model($user)->update_pic($_SESSION["id"], './Views/images/' . $_FILES['file_pic']['name']);
                }
                $this->model($user)->update_profile_nope_img($_SESSION["id"], $_POST["fname"], $_POST["username"], $_POST["cmnd"], $_POST["phone"], $_POST["address"], $_POST["mail"]);
            }
            $this->member_page($user);
            
        }
        function update_password_profile($user, $array){
            if($this->model($user)->update_password_profile($_SESSION["id"], (string)$array[2])){
                echo "ok";
            }
            else echo "null";
        }
        public function create_cart($user) {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $size = $_POST['size'] ?? null;
        
            if (empty($productId) || empty($quantity) || $quantity <= 0 || empty($size)) {
                echo json_encode(["status" => "error", "message" => "Thiếu thông tin sản phẩm"]);
                return;
            }
        
            if (!isset($_SESSION["id"])) {
                echo json_encode(["status" => "error", "message" => "Vui lòng đăng nhập để thêm sản phẩm vào giỏ"]);
                return;
            }
        
            $this->model($user)->create_cart($_SESSION["id"], $productId, $quantity, $size);
        
            echo json_encode(["status" => "success", "message" => "Thêm sản phẩm vào giỏ hàng thành công"]);
        }               
        
        function sendmessage($user, $array){
            $to = explode("-", $array[2])[1];
            $subject = explode("-", $array[3])[1];
            $message = explode("-", $array[4])[1];
            if(mail($to, $subject, $message)){
                $this->model($user)->update_message((int)$array[5]);
            }
            else echo "null";
        }

        function sort_comment($user, $array){
        $result = $this->model($user)->get_item_comment((int)$array[2], $array[3]);
        $cmt_info = array();

    foreach($result as $cmt){
        array_push($cmt_info, [
            "id" => $cmt["id"],
            "pid" => $cmt["pid"],
            "uid" => $cmt["uid"],
            "uname" => $this->model($user)->get_cmt_user_name($cmt["uid"]),
            "star" => $cmt["star"],
            "content" => $cmt["content"],
            "time" => $cmt["time"]
        ]);
    }

    echo "<div class=\"no-filter-cmt\"></div>";

    if (empty($cmt_info)) {
        echo "<div class=\"card\">
                <div class=\"card-body\" id=\"if-no-cmt\">No comment</div>
              </div>";
    } else {
        foreach ($cmt_info as $row) {
            echo "<div class=\"card filterCmt " . $row["star"] . "-star-num\">
                    <div class=\"card-body\">
                        <div class=\"header-cmt\">
                            <div>
                                <i class=\"fas fa-user-circle\"></i>";
                                foreach($row["uname"] as $name) {
                                    echo "<span> " . $name["uname"] . "</span>";
                                }
                                echo "<div class=\"star-cus-rate\">";
                                    for ($i = 0; $i < $row["star"]; $i++) {
                                        echo "<i class=\"fas fa-star\"></i>";
                                    }
                                    for ($i = 0; $i < 5 - $row["star"]; $i++) {
                                        echo "<i class=\"far fa-star\"></i>";
                                    }
                                echo "</div>
                            </div>
                            <div>
                                <p>" . $row["time"] . "</p>
                            </div>
                        </div>
                        <div class=\"comment-content\">
                            <div class=\"script-cmt\">
                                <p>" . $row["content"] . "</p>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }
}

        function logout($user){
            if ($user == "member") {
                $cart_result = $this->model($user)->get_sum_cart($_SESSION["id"]);
                if ($cart_result) {
                    $cart = mysqli_fetch_array($cart_result)["sum"];
                    $total = 0;
                    if ($cart != NULL) $total += (int)$cart;
                    $this->model($user)->update_Rank($_SESSION["id"], $total);
                } else {
                    error_log("Failed to fetch cart sum for user " . $_SESSION["id"]);
                }
            }
            session_unset(); 
            $this->Home_page("customer");
        }
        
        function change_passwork($user, $array){
            $to = mysqli_fetch_array($this->model($user)->change_passwork($array[2]))["mail"];
            echo $to;
            if( $to != ""){
                $subject = "CHANGE PASSWORD";
                $message = "Chào bạn, \nMật khẩu mới của bạn sẽ là: 123456hello\n";
                if(mail($to, $subject, $message)){
                    $this->model($user)->change_passwork_mail($to, "123456hello");
                    echo "OK";
                }
                else{ echo "null";}
            }
            else{ echo "null";}
        }

        function get_user($user, $array){
            $data = $this->model($user)->get_user((int)$array[2]);
            if(!empty($data)){
                foreach($data as $row){
                    echo "</div class=\"row\">";
                    echo "<div class=\"col-12\">
                            <div class=\"row\">
                                <div class=\"col-4\"><strong>Họ và tên:</strong></div>
                                <div class=\"col-8\"><h5>" . $row["name"] .  "</h5></div>
                            </div>
                        </div>";
                    echo "<div class=\"col-12\">
                            <div class=\"row\">
                                <div class=\"col-4\"><strong>CMND/CCCD:</strong></div>
                                <div class=\"col-8\"><h5>" . $row["cmnd"] .  "</h5></div>
                            </div>
                        </div>";
                    echo "<div class=\"col-12\">
                            <div class=\"row\">
                                <div class=\"col-4\"><strong>SĐT:</strong></div>
                                <div class=\"col-8\"><h5>" . $row["phone"] .  "</h5></div>
                            </div>
                        </div>";
                    echo "<div class=\"col-12\">
                            <div class=\"row\">
                                <div class=\"col-4\"><strong>Email:</strong></div>
                                <div class=\"col-8\"><h5>" . $row["mail"] .  "</h5></div>
                            </div>
                        </div>";
                    echo "</div>";
                }
            }
            else echo "null";
        }
        function remove_user($user, $array){
            if($this->model($user)->remove_user((int)$array[2])) echo "ok";
            else echo "null";
        }
        function ban_user($user, $array){
            if($this->model($user)->ban_user((int)$array[2])){
                if($this->model($user)->remove_user($array[2])) echo "ok";
                else echo "null";
            }
            else echo "null";
        }

        function create_account($user, $array) {
            $exist_check = $this->model($user)->check_account_inside($array[3], $array[4]);
            if (mysqli_num_rows($exist_check) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Tài khoản hoặc email đã tồn tại!']);
                return;
            }
            $success = $this->model($user)->create_account(
                $array[2],
                $array[3],
                $array[4],
                $array[5],
                $array[6]
            );
        
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Tạo tài khoản thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi khi tạo tài khoản!']);
            }
        }

        function cancel($user) {
            if (!isset($_SESSION['id']) || $user !== "member") {
                die("Bạn chưa đăng nhập.");
            }
            if (!isset($_POST['order_id'])) {
                die("Thiếu mã đơn hàng.");
            }
            $order_id = (int)$_POST['order_id'];
            $model = $this->model($user);
        
            // 🔧 FIX lỗi ở đây: convert mysqli_result -> array
            $order = mysqli_fetch_assoc($model->get_order_by_id($order_id));
        
            if (!$order || $order['uid'] != $_SESSION['id']) {
                die("Đơn hàng không tồn tại hoặc bạn không có quyền hủy.");
            }
            if ((int)$order['state'] !== 0) {
                die("Chỉ đơn hàng đang chờ xác nhận mới được hủy.");
            }
            if ($model->cancel_order($order_id)) {
                header("Location: ?url=OrderDetail/index&id=$order_id");
                exit();
            } else {
                die("Hủy đơn hàng thất bại.");
            }
        }     
    }
?>