<?php
require_once "./Model/customer.php";
class member extends customer{
    public function get_product_in_cart($id){
        $query =    "SELECT `cart`.`ID` AS `id`,
                            `product`.`NAME` AS `name`, 
                            `product`.`PRICE` AS `price`,
                            `product`.`IMG_URL` AS `img`,
                            `cart`.`QUANTITY` AS `num`,
                            `cart`.`SIZE` AS `size`
                    FROM `cart`, `product`, `account`
                    WHERE `product`.`ID` = `cart`.`PID`
                        AND `cart`.`UID` = " . $id . "
                        AND `account`.`ID` = " . $id . ";";
                        // test_array($query);
        return mysqli_query($this->connect, $query);
    }
    public function get_product_in_cart_mem($id){
        $query =    "SELECT `product`.`ID` AS `id`,
                            `product`.`NAME` AS `name`, 
                            `product`.`PRICE` AS `price`,
                            `product`.`IMG_URL` AS `img`,
                            `cart`.`QUANTITY` AS `num`,
                            `cart`.`SIZE` AS `size`
                    FROM `cart`, `product`, `account`
                    WHERE `product`.`ID` = `cart`.`PID`
                        AND `cart`.`UID` = `account`.`ID`
                        AND `cart`.`ID` = " . $id . ";";
        return mysqli_query($this->connect, $query);
    }
    public function get_product_in_order_detail($order_id) {
        $query = "SELECT 
                    `product`.`ID` AS `id`,
                    `product`.`NAME` AS `name`,
                    `product`.`PRICE` AS `price`,
                    `product`.`IMG_URL` AS `img`,
                    `order_detail`.`QUANTITY` AS `num`,
                    `order_detail`.`SIZE` AS `size`
                FROM `order_detail`, `product`
                WHERE `order_detail`.`PID` = `product`.`ID`
                  AND `order_detail`.`order_id` = " . (int)$order_id . ";";
                  
        return mysqli_query($this->connect, $query);
    }
    public function get_user($id){
        $query =    "SELECT `account`.`FNAME` AS `name`,
                            `account`.`PHONE` AS `phone`, 
                            `account`.`ADDRESS` AS `add`, 
                            `account`.`USERNAME` AS `username`, 
                            `account`.`IMG_URL` AS `img`, 
                            `account`.`CMND` AS `cmnd`, 
                            `account`.`PWD` AS `pwd`, 
                            `account`.`EMAIL` AS `mail`
                    FROM    `account`
                    WHERE   `account`.`ID` = " . $id;
        return mysqli_query($this->connect, $query);
    }
    public function update_user($id, $fname, $phone, $add){
        $query =    "UPDATE `account`
                    SET `account`.`FNAME` = \"" . $fname . "\", `account`.`PHONE` = \"" . $phone ."\", `account`.`ADDRESS` = \"" . $add . "\"
                    WHERE `account`.`ID` = " . $id .";";
        return mysqli_query($this->connect, $query);
    }
    public function update_password_profile($id, $pwd){
        $query =    "UPDATE `account`
                    SET `account`.`PWD` = \"" . $pwd . "\"
                    WHERE `account`.`ID` = " . $id .";";
        return mysqli_query($this->connect, $query);
    }
    public function delete_product_incart($id){
        $query =    "DELETE FROM `cart` WHERE `cart`.`ID` = " . $id .";";
        return mysqli_query($this->connect, $query);
    }
    public function update_product_in_cart($id, $quantity, $size){
        if($quantity == 0){
            $this->delete_product_incart($id);
        }
        else{
            $query =    "UPDATE `cart`
                        SET `cart`.`QUANTITY` = " . $quantity . ", `cart`.`SIZE` = \"" . $size ."\"
                        WHERE `cart`.`ID` = " . $id;
            return  mysqli_query($this->connect, $query);
        }
    }
    
    public function get_cart($id){
        $query =    "SELECT `cart`.`ID` AS `id`
                    FROM `cart`, `account`
                    WHERE `cart`.`UID` = " . $id ."
                    GROUP BY `cart`.`ID`";
        return  mysqli_query($this->connect, $query);
    }
    public function update_profile_nope_img($id, $fname, $user, $cmnd, $phone, $add, $mail){
        $query =    "UPDATE `account`
                    SET `account`.`CMND` = \"" . $cmnd . "\",
                        `account`.`FNAME` = \"" . $fname . "\",
                        `account`.`PHONE` = \"" . $phone . "\",
                        `account`.`ADDRESS` = \"" . $add . "\",
                        `account`.`USERNAME` = \"" . $user . "\",
                        `account`.`EMAIL` = \"" . $mail . "\"
                    WHERE `account`.`ID` = " . $id ;
        return mysqli_query($this->connect, $query);
    }
    public function get_cart_for_session(){
        $query =    "SELECT MAX(`cart`.`ID`) AS `id` FROM `cart`" ;
        return mysqli_query($this->connect, $query);
    }
    public function create_cart($id, $id_product, $quantity){
        $result = mysqli_query($this->connect, "SELECT `ID` FROM `cart` WHERE `UID` = $id AND PID = $id_product");
        $row = mysqli_fetch_assoc($result);
        $check_exist_product = $row['ID'] ?? null;
    
        if($check_exist_product) {
            $query = "UPDATE `cart` SET `QUANTITY` = `QUANTITY` + $quantity WHERE `ID` = $check_exist_product";
        } else {
            $query = "INSERT INTO `cart` (`cart`.`UID`, `cart`.`PID`, `cart`.`QUANTITY`) VALUES($id, $id_product, $quantity)";
        }
    
        return mysqli_query($this->connect, $query);
    }
    
    public function update_pic($id ,$path){
        $query =    "UPDATE `account`
                    SET `account`.`IMG_URL` = \"" . $path . "\"
                    WHERE `account`.`ID` = " . $id ;
        return mysqli_query($this->connect, $query);
    }
    function add_comment_news($content, $nid, $cid){
        $query = "INSERT INTO `comment_news` (`nid`, `cid`, `content`, `time`) VALUE (" . $nid . ", " . $cid . ", \"" . $content . "\", \"" . date("Y/m/d") . "\")";
        return mysqli_query($this->connect, $query);
    }
    public function get_sum_cart($id){
        $query =    "SELECT SUM(`cart`.`QUANTITY`*`product`.`PRICE`)  as `sum`
                    FROM `product`, `cart`, `account`
                    WHERE   `cart`.`PID` = `product`.`ID`
                        AND `cart`.`UID` = `account`.`ID`
                        AND `account`.`ID` = " . $id;
        return mysqli_query($this->connect, $query);
    }
    public function update_Rank($id, $rank){
        $query =    "UPDATE `account`
                    SET `account`.`RANK` = " . $rank . "
                    WHERE `account`.`ID` = " . $id ;
        return mysqli_query($this->connect, $query);
    }
    public function clear_cart($uid) {
        $query = "DELETE FROM cart WHERE UID = " . intval($uid);
        $result = mysqli_query($this->connect, $query);
    }
    public function get_order_by_id($id) {
        $query = "SELECT `STATUS` AS `state`, `TIME` AS `time`,`UID` AS `uid`,`TOTAL_PRICE` AS `total`, `METHOD` AS `method`
                FROM `order` WHERE `ID` = $id";
        return mysqli_query($this->connect, $query);
    }
    
    public function cancel_order($order_id) {
        $query = "UPDATE cart SET STATE = 4 WHERE ID = " . $order_id;
        return mysqli_query($this->connect, $query);
    }    
    public function get_cart_by_id($id){
        $query = "SELECT `UID` as `uid`, `PID` as `pid`, `SIZE` as `size`, `QUANTITY` as `quantity`
                  FROM `cart` WHERE `ID` = $id";
        return mysqli_query($this->connect, $query);
    } 
    public function update_payment_method($oid, $method) {
        $query = "UPDATE cart SET METHOD = '$method' WHERE ID = $oid";
        return mysqli_query($this->connect, $query);
    }
    public function get_orders($uid) {
        $orders = [];
        $conn = $this->connect;
    
        // 1. Truy vấn danh sách đơn hàng theo UID
        $order_sql = "SELECT * FROM `order` WHERE UID = ? ORDER BY TIME DESC";
        $stmt_order = $conn->prepare($order_sql);
        if (!$stmt_order) {
            die("❌ Lỗi prepare order_sql: " . $conn->error);
        }
    
        $stmt_order->bind_param("i", $uid);
        $stmt_order->execute();
        $result_order = $stmt_order->get_result();
    
        // 2. Lặp từng đơn hàng
        while ($order = $result_order->fetch_assoc()) {
            $order_id = $order["ID"];
    
            // 2.1 Truy vấn chi tiết sản phẩm trong đơn hàng
            $detail_sql = "SELECT od.*, p.NAME, p.IMG_URL 
                           FROM order_detail od 
                           JOIN product p ON od.PID = p.ID 
                           WHERE od.ORDER_ID = ?";
            $stmt_detail = $conn->prepare($detail_sql);
            if (!$stmt_detail) {
                die("❌ Lỗi prepare detail_sql: " . $conn->error);
            }
    
            $stmt_detail->bind_param("i", $order_id);
            $stmt_detail->execute();
            $result_detail = $stmt_detail->get_result();
    
            $details = [];
            while ($row = $result_detail->fetch_assoc()) {
                $details[] = $row;
            }
    
            // 2.2 Gắn chi tiết vào đơn hàng
            $order["details"] = $details;
            $orders[] = $order;
        }
    
        return $orders;
    }
    
    public function create_order_from_cart(int $uid, string $method = 'COD') {
        $conn = (new DB())->connect;

        // 1) Lấy cart
        $sql    = "
            SELECT c.PID AS PID,
                   c.SIZE AS SIZE,
                   c.QUANTITY AS QUANTITY,
                   p.PRICE AS PRICE
            FROM cart c
            JOIN product p ON p.ID = c.PID
            WHERE c.UID = " . intval($uid);
        $res    = mysqli_query($conn, $sql);
        $items  = [];
        $total  = 0.0;
        while ($row = mysqli_fetch_assoc($res)) {
            $row['PID']      = (int)   $row['PID'];
            $row['SIZE']     =       $row['SIZE'];  // giữ nguyên string (S, M, L, ...)
            $row['QUANTITY'] = (int)   $row['QUANTITY'];
            $row['PRICE']    = (float) $row['PRICE'];
            $items[] = $row;
            $total  += $row['PRICE'] * $row['QUANTITY'];
        }

        // Nếu giỏ trống, không tạo order
        if (empty($items)) {
            return false;
        }

        // 2) Tạo order
        $time   = date('Y-m-d H:i:s');
        $status = 'Chờ xác nhận';
        $stmt   = $conn->prepare(
            "INSERT INTO `order` (UID, TIME, STATUS, TOTAL_PRICE, METHOD) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issds", $uid, $time, $status, $total, $method);
        $stmt->execute();
        $oid = $conn->insert_id;
        if (!$oid) {
            throw new Exception('Không tạo được order_id');
        }

        // 3) Chèn chi tiết
        $stmt2 = $conn->prepare(
            "INSERT INTO `order_detail` (order_id, PID, SIZE, QUANTITY) VALUES (?, ?, ?, ?)"
        );
        foreach ($items as $item) {
            // Thay đổi kiểu bind_param: SIZE là string
            $stmt2->bind_param(
                "iisd",
                $oid,
                $item['PID'],
                $item['SIZE'],
                $item['QUANTITY']
            );
            $stmt2->execute();
        }

        // 4) Xóa cart
        mysqli_query($conn, "DELETE FROM cart WHERE UID = " . intval($uid));

        return $oid;
    }
       
    public function reorder($old_order_id, $uid) {
        $conn = $this->connect;
    
        // 1. Lấy lại chi tiết đơn hàng cũ
        $stmt_old = $conn->prepare("SELECT PID, SIZE, QUANTITY FROM order_detail WHERE ORDER_ID = ?");
        $stmt_old->bind_param("i", $old_order_id);
        $stmt_old->execute();
        $result = $stmt_old->get_result();
    
        $details = [];
        $total = 0;
    
        while ($row = $result->fetch_assoc()) {
            // Kiểm tra xem sản phẩm này có tồn tại không trong bảng product
            $stmt_check = $conn->prepare("SELECT PRICE, IMG_URL FROM product WHERE ID = ?");
            $stmt_check->bind_param("i", $row["PID"]);
            $stmt_check->execute();
            $res = $stmt_check->get_result();
            
            if ($res && $price_row = $res->fetch_assoc()) {
                // Nếu sản phẩm tồn tại, thêm vào chi tiết đơn hàng
                $row["PRICE"] = $price_row["PRICE"]; // Lưu giá để tính tổng
                $row["IMG_URL"] = $price_row["IMG_URL"]; // Lưu đường dẫn ảnh
                $details[] = $row;
                $total += $price_row["PRICE"] * $row["QUANTITY"];
            }
        }
    
        if (empty($details)) return false; // Không có sản phẩm hợp lệ
    
        // 2. Tạo đơn hàng mới
        $today = date("Y-m-d");
        $status = "Chờ xác nhận";
        $stmt_insert_order = $conn->prepare("INSERT INTO `order` (UID, TIME, STATUS, TOTAL_PRICE) VALUES (?, ?, ?, ?)");
        $stmt_insert_order->bind_param("issd", $uid, $today, $status, $total);
        $stmt_insert_order->execute();
    
        $new_order_id = $conn->insert_id;
    
        // 3. Chèn lại vào order_detail
        $stmt_insert_detail = $conn->prepare("INSERT INTO order_detail (ORDER_ID, PID, SIZE, QUANTITY) VALUES (?, ?, ?, ?)");
        
        foreach ($details as $d) {
            $stmt_insert_detail->bind_param("issi", $new_order_id, $d["PID"], $d["SIZE"], $d["QUANTITY"]);
            $stmt_insert_detail->execute();
        }
    
        return $new_order_id;
    }
    public function insert_order_detail($order_id, $uid) {
        $conn = $this->connect;
        $sql = "INSERT INTO order_detail (ORDER_ID, PID, SIZE, QUANTITY)
                SELECT $order_id, c.PID, c.SIZE, c.QUANTITY
                FROM cart c
                WHERE c.UID = ?";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("❌ Lỗi prepare insert_order_detail: " . $conn->error);
        }
        $stmt->bind_param("i", $uid);
        return $stmt->execute();
    }
    
    
}
?>