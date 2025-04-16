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
    public function get_order_by_id($order_id) {
        $query = "SELECT * FROM cart WHERE ID = " . $order_id;
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result); // Trả về 1 dòng
    }
    
    public function cancel_order($order_id) {
        $query = "UPDATE cart SET STATE = 4 WHERE ID = " . $order_id;
        return mysqli_query($this->connect, $query);
    }    
    public function get_cart_by_id($id){
        $query = "SELECT `STATE` as `state`, `TIME` as `time`
                  FROM `cart` WHERE `ID` = " . (int)$id;
        return mysqli_query($this->connect, $query);
    }    
    public function update_payment_method($oid, $method) {
        $query = "UPDATE cart SET METHOD = '$method' WHERE ID = $oid";
        return mysqli_query($this->connect, $query);
    }    
}
?>