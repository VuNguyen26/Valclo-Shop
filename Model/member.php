<?php
require_once "./Model/customer.php";
class member extends customer{
    public function get_product_in_cart($id){
        $query =    "SELECT `product_in_cart`.`ID` AS `id`,
                            `product`.`NAME` AS `name`, 
                            `product`.`PRICE` AS `price`,
                            `product`.`IMG_URL` AS `img`,
                            `product_in_cart`.`QUANTITY` AS `num`,
                            `product_in_cart`.`SIZE` AS `size`,
                            `product_in_cart`.`OID` AS `oid`
                    FROM `cart`, `product_in_cart`, `product`, `account`
                    WHERE `cart`.`ID` = `product_in_cart`.`OID`
                        AND `cart`.`STATE` = 0
                        AND `product`.`ID` = `product_in_cart`.`PID`
                        AND `cart`.`UID` = " . $id . "
                        AND `account`.`ID` = " . $id . ";";
        return mysqli_query($this->connect, $query);
    }
    public function get_product_in_cart_mem($id){
        $query =    "SELECT `product`.`ID` AS `id`,
                            `product`.`NAME` AS `name`, 
                            `product`.`PRICE` AS `price`,
                            `product`.`IMG_URL` AS `img`,
                            `product_in_cart`.`QUANTITY` AS `num`,
                            `product_in_cart`.`SIZE` AS `size`
                    FROM `cart`, `product_in_cart`, `product`, `account`
                    WHERE `cart`.`ID` = `product_in_cart`.`OID`
                        AND `product`.`ID` = `product_in_cart`.`PID`
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
        $query =    "DELETE FROM `product_in_cart` WHERE `product_in_cart`.`ID` = " . $id .";";
        return mysqli_query($this->connect, $query);
    }
    public function update_product_in_cart($id, $quantity, $size){
        if($quantity == 0){
            $this->delete_product_incart($id);
        }
        else{
            $query =    "UPDATE `product_in_cart`
                        SET `product_in_cart`.`QUANTITY` = " . $quantity . ", `product_in_cart`.`SIZE` = \"" . $size ."\"
                        WHERE `product_in_cart`.`ID` = " . $id;
            return  mysqli_query($this->connect, $query);
        }
    }
    public function update_cart($oid) {
        // Trừ tồn kho
        $query = "UPDATE product p
                  JOIN product_in_cart pic ON p.ID = pic.PID
                  SET p.NUMBER = p.NUMBER - pic.QUANTITY
                  WHERE pic.OID = $oid";
        mysqli_query($this->connect, $query);
    
        // Cập nhật trạng thái cart
        $query = "UPDATE cart SET STATE = 1 WHERE ID = $oid";
        return mysqli_query($this->connect, $query);
    }
     
    public function get_cart($id){
        $query =    "SELECT     `cart`.`ID` AS `id`,   
                                `cart`.`TIME` AS `time`, 
                                `cart`.`STATE` AS `state`
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
    public function create_cart($id, $time){
        $query =    "INSERT INTO `cart` (`cart`.`UID`, `cart`.`TIME`)
                    VALUES(" . $id . ", \"" . $time . "\");";
        return mysqli_query($this->connect, $query);
    }
    public function create_product_incart($pid, $oid, $quantity){
        $query =    "INSERT INTO `product_in_cart`(`product_in_cart`.`PID`, `product_in_cart`.`OID`, `product_in_cart`.`QUANTITY`)
                    VALUES (" . $pid . ", " . $oid . ", " . $quantity . ");";
        return mysqli_query($this->connect, $query);
    }
    public function update_pic($id ,$path){
        $query =    "UPDATE `account`
                    SET `account`.`IMG_URL` = \"" . $path . "\"
                    WHERE `account`.`ID` = " . $id ;
        return mysqli_query($this->connect, $query);
    }
    public function create_order_combo($uid, $time, $cbid, $cycle, $size){
        $query =    "INSERT INTO `order_combo`(`order_combo`.`UID`, `order_combo`.`CBID`, `order_combo`.`TIME`, `order_combo`.`CYCLE`, `order_combo`.`SIZE`)
                    VALUES(" . $uid . ", " . $cbid . ", \"" . $time . "\", " . $cycle . ", \"" . $size . "\");";
        return mysqli_query($this->connect, $query);
    }
    public function update_order_combo($id){
        $query =    "UPDATE `order_combo`
                    SET `order_combo`.`STATE` = 1
                    WHERE `order_combo`.`UID` = " . $id;
        return mysqli_query($this->connect, $query);
    }
    public function delete_order_combo($id){
        $query =    "DELETE FROM `order_combo` WHERE `order_combo`.`STATE` = 0 AND `order_combo`.`UID` = " . $id;
        return mysqli_query($this->connect, $query);
    }
    function delete_order_combo_cbid($id, $cbid){
        $query =    "DELETE FROM `order_combo` WHERE `order_combo`.`UID` = " . $id . " AND `order_combo`.`CBID` = " . $cbid . " AND `order_combo`.`STATE` = 0";
        return mysqli_query($this->connect, $query);
    }
    function add_comment_news($content, $nid, $cid){
        $query = "INSERT INTO `comment_news` (`nid`, `cid`, `content`, `time`) VALUE (" . $nid . ", " . $cid . ", \"" . $content . "\", \"" . date("Y/m/d") . "\")";
        return mysqli_query($this->connect, $query);
    }
    public function get_sum_cart($id){
        $query =    "SELECT SUM(`product_in_cart`.`QUANTITY`*`product`.`PRICE`)  as `sum`
                    FROM `product`, `product_in_cart`, `cart`, `account`
                    WHERE   `product_in_cart`.`PID` = `product`.`ID`
                        AND `product_in_cart`.`OID` = `cart`.`ID`
                        AND `cart`.`UID` = `account`.`ID`
                        AND `cart`.`STATE` = 1
                        AND `account`.`ID` = " . $id;
        return mysqli_query($this->connect, $query);
    }
    public function update_Rank($id, $rank){
        $query =    "UPDATE `account`
                    SET `account`.`RANK` = " . $rank . "
                    WHERE `account`.`ID` = " . $id ;
        return mysqli_query($this->connect, $query);
    }
    public function clear_cart(){
        $query =    "DELETE FROM `cart` 
                    WHERE `cart`.`ID` NOT IN (  SELECT `cart`.`ID` FROM `product_in_cart`, `cart`
                                                WHERE `product_in_cart`.`OID` = `cart`.`ID`
                                                GROUP BY `cart`.`ID`)";
        return mysqli_query($this->connect, $query);
    }
    public function delete_order_combo_id($id){
        $query =    "DELETE FROM `order_combo` WHERE `order_combo`.`ID` = " . $id;
        return mysqli_query($this->connect, $query);
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