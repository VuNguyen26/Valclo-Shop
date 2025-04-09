<?php
class customer extends DB {
    public function get_swiper_slide_collection() {
        $query = "SELECT `product`.`IMG_URL` AS 'img', `product`.`CATEGORY` AS 'cate' FROM `product` WHERE `product`.`TOP_PRODUCT` = 1;";
        return mysqli_query($this->connect, $query);
    }

    public function get_product_cates() {
        $query = "SELECT `product`.`CATEGORY` AS 'cate' FROM `product` GROUP BY `product`.`CATEGORY` ORDER BY `product`.`ID`;";
        return mysqli_query($this->connect, $query);
    }

    public function get_products($param) {
        $query = "";
        isset($param[2]) ? $sort_1 = $param[2] : $sort_1 = '';
        isset($param[3]) ? $sort_2 = $param[3] : $sort_2 = '';

        if ($sort_1 == "" && $sort_2 == "") {
            $query = "SELECT `product`.`ID` AS 'id', `product`.`IMG_URL` AS 'img', `product`.`NAME` AS 'name', `product`.`PRICE` AS 'price', `product`.`DECS` AS 'decs', `product`.`CATEGORY` as 'cate', `product`.`TOP_PRODUCT` as 'top_seller' FROM `product`;";
        } else if ($sort_1 == "pname") {
            $query = "SELECT `product`.`ID` AS 'id', `product`.`IMG_URL` AS 'img', `product`.`NAME` AS 'name', `product`.`PRICE` AS 'price', `product`.`DECS` AS 'decs', `product`.`CATEGORY` as 'cate', `product`.`TOP_PRODUCT` as 'top_seller' FROM `product` ORDER BY `product`.`NAME` $sort_2;";
        } else if ($sort_1 == "price") {
            $query = "SELECT `product`.`ID` AS 'id', `product`.`IMG_URL` AS 'img', `product`.`NAME` AS 'name', `product`.`PRICE` AS 'price', `product`.`DECS` AS 'decs', `product`.`CATEGORY` as 'cate', `product`.`TOP_PRODUCT` as 'top_seller' FROM `product` ORDER BY `product`.`PRICE` $sort_2;";
        } else die('404 Not Found');
        return mysqli_query($this->connect, $query);
    }

    public function get_combo() {
        $query = "SELECT `combo`.`NAME` AS `cbname`, `combo`.`COST` AS `cost`, `combo`.`ID` AS `id` FROM `combo`";
        return mysqli_query($this->connect, $query);
    }

    public function get_product_in_combo($id) {
        $query = "SELECT `product`.`NAME` AS `name` FROM `product_in_combo`, `product` WHERE `product_in_combo`.`PID` = `product`.`ID` AND `product_in_combo`.`CBID` = $id";
        return mysqli_query($this->connect, $query);
    }

    public function get_cycle() {
        $query = "SELECT `cycle`.`CYCLE` AS `cycle` FROM `cycle`;";
        return mysqli_query($this->connect, $query);
    }

    public function get_cycle_id($id) {
        $query = "SELECT `cycle`.`CYCLE` AS `cycle` FROM `cycle` WHERE `cycle`.`ID` = $id;";
        return mysqli_query($this->connect, $query);
    }

    public function insert_message($fname, $email, $phone, $subject, $content) {
        $query = "INSERT INTO `message`(`FNAME`, `EMAIL`, `PHONE`, `SUBJECT`, `CONTENT`) VALUES ('$fname', '$email', '$phone', '$subject', '$content');";
        return mysqli_query($this->connect, $query);
    }

    public function get_product_at_id($pid) {
        $query = "SELECT `ID` AS `id`, `IMG_URL` AS 'img', `NAME` AS 'name', `PRICE` AS 'price', `NUMBER` AS 'num', `DECS` AS 'decs', `CATEGORY` as 'cate', `TOP_PRODUCT` as 'top_item' FROM `product` WHERE `ID` = $pid;";
        return mysqli_query($this->connect, $query);
    }

    public function get_sub_img($pid) {
        $query = "SELECT `IMG_URL` AS 'img' FROM `sub_img_url` WHERE `PID` = $pid;";
        return mysqli_query($this->connect, $query);
    }

    public function get_product_same_cate($pid) {
        $sql = "SELECT `CATEGORY` as 'cate' FROM `product` WHERE `ID` = $pid;";
        $cate_temp = mysqli_query($this->connect, $sql);
        $cate = mysqli_fetch_array($cate_temp)['cate'];
        $query = "SELECT `ID` AS 'id', `IMG_URL` AS 'img', `NAME` AS 'name', `PRICE` AS 'price', `DECS` AS 'decs', `CATEGORY` as 'cate' FROM `product` WHERE `CATEGORY` = '$cate';";
        return mysqli_query($this->connect, $query);
    }

    public function get_item_comment($pid, $sort) {
        $order = '';
        if ($sort == 'high-first') $order = 'ORDER BY `STAR` DESC';
        else if ($sort == 'low-first') $order = 'ORDER BY `STAR` ASC';
        $query = "SELECT `ID` AS 'id', `PID` AS 'pid', `UID` AS 'uid', `STAR` AS 'star', `CONTENT` AS 'content', `TIME` AS 'time' FROM `comment` WHERE `PID` = $pid $order;";
        return mysqli_query($this->connect, $query);
    }

    public function get_cmt_user_name($uid) {
        $query = "SELECT `FNAME` AS 'uname' FROM `account` WHERE `ID` = $uid;";
        return mysqli_query($this->connect, $query);
    }

    public function get_news() {
        $query = "SELECT `ID` as `id`, `CID` as `cid`, `KEY` as `key`, `TIME` as `time`, `TITLE` as `title`, `CONTENT` as `content`, `IMG_URL` as `img_url`, `SHORT_CONTENT` as `short_content` FROM `news`;";
        return mysqli_query($this->connect, $query);
    }

    public function delete_news($id) {
        $query = "DELETE FROM `news` WHERE `id` = $id";
        return mysqli_query($this->connect, $query);
    }

    public function get_comment_news($id) {
        $query = "SELECT `account`.`FNAME` as `name`, `comment_news`.`CONTENT` as `content`, `comment_news`.`TIME` as `time` FROM `comment_news`, `account` WHERE `comment_news`.`CID` = `account`.`ID` AND `comment_news`.`NID` = $id";
        return mysqli_query($this->connect, $query);
    }

    public function get_id_user($username, $pwd) {
        $query = "SELECT `ID` AS `id` FROM `account` WHERE `USERNAME` = '$username' AND `PWD` = '$pwd';";
        return mysqli_query($this->connect, $query);
    }

    public function add_item_comment($content, $rating, $pid, $uid) {
        $date = date("Y/m/d");
        $query = "INSERT INTO `comment`(`PID`, `UID`, `STAR`, `CONTENT`, `TIME`) VALUES ($pid, $uid, $rating, '$content', '$date');";
        return mysqli_query($this->connect, $query);
    }

    public function change_passwork($mail) {
        $query = "SELECT `EMAIL` AS `mail` FROM `account` WHERE `EMAIL` = '$mail';";
        return mysqli_query($this->connect, $query);
    }

    public function change_passwork_mail($mail, $pwd) {
        $query = "UPDATE `account` SET `PWD` = '$pwd' WHERE `EMAIL` = '$mail';";
        return mysqli_query($this->connect, $query);
    }

    public function get_sum_cart($id) {
        $query = "SELECT SUM(`product_in_cart`.`QUANTITY` * `product`.`PRICE`) FROM `product`, `product_in_cart`, `cart`, `account` WHERE `product_in_cart`.`PID` = `product`.`ID` AND `product_in_cart`.`OID` = `cart`.`ID` AND `cart`.`UID` = `account`.`ID` AND `cart`.`STATE` = 1 AND `account`.`ID` = $id;";
        return mysqli_query($this->connect, $query);
    }

    public function get_sum_order_Combo($id) {
        $query = "SELECT SUM(`combo`.`COST`) FROM `combo`, `order_combo`, `account` WHERE `order_combo`.`CBID` = `combo`.`ID` AND `order_combo`.`UID` = `account`.`ID` AND `account`.`ID` = $id;";
        return mysqli_query($this->connect, $query);
    }

    public function check_account_ban($cmnd) {
        $query = "SELECT `ID` as `id` FROM `ban_account` WHERE `CMND` = '$cmnd';";
        return mysqli_query($this->connect, $query);
    }

    public function check_account_inside($cmnd, $mail) {
        $query = "SELECT `ID` as `id` FROM `account` WHERE `EMAIL` = '$mail' OR `CMND` = '$cmnd';";
        return mysqli_query($this->connect, $query);
    }

    public function create_account($fname, $cmnd, $mail, $user, $pwd){
        $query = "INSERT INTO `account` (
            `CMND`, `FNAME`, `PHONE`, `ADDRESS`, 
            `USERNAME`, `PWD`, `IMG_URL`, `RANK`, `EMAIL`
        ) VALUES (
            '" . mysqli_real_escape_string($this->connect, $cmnd) . "',
            '" . mysqli_real_escape_string($this->connect, $fname) . "',
            '', '', 
            '" . mysqli_real_escape_string($this->connect, $user) . "',
            '" . mysqli_real_escape_string($this->connect, $pwd) . "',
            './Views/images/np.png', 
            0,
            '" . mysqli_real_escape_string($this->connect, $mail) . "'
        )";
    
        return mysqli_query($this->connect, $query);
    }           
}
?>