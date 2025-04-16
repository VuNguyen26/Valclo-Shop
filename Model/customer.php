<?php
class customer extends DB {
    public function get_swiper_slide_collection() {
        $query = "SELECT `product`.`IMG_URL` AS 'img', `product`.`CATEGORY` AS 'cate' FROM `product` WHERE `product`.`TOP_PRODUCT` = 1;";
        return mysqli_query($this->connect, $query);
    }

    public function get_product_cates() {
        $query = "SELECT `name_category` FROM `category` `c` WHERE `c`.`STATE` = 1 ";
        return mysqli_query($this->connect, $query);
    }

    public function check_exist_cate($name) {
        $query = "SELECT `id` FROM `category` `c` WHERE `c`.`STATE` = 1 AND `c`.`name_category` = '$name' ";
        return mysqli_fetch_assoc(mysqli_query($this->connect, $query));
    }

    public function get_products($sort_1, $sort_2, $page, $search = null, $category) {

        # variable
        $query = ""; // câu truy vấn tổng
        $query_paginate = ""; // câu truy vấn phân trang LIMIT, OFFSET
        $limit_record = 12; // giới hạn số sản phẩm trên 1 trang
    
        # sort
        if(!in_array($sort_1,['collection','featured','pname','price'])) $sort_1 = null;
        if(!in_array($sort_2,['ASC','DESC'])) $sort_2 = null;
    
        # điều kiện tìm kiếm
        $search_condition = " 1";
        if ($search !== null && $search !== "") {
            $search = mysqli_real_escape_string($this->connect, $search); // tránh SQL injection
            $search_condition = " WHERE `product`.`NAME` LIKE '%$search%' ";
        }

        # cateories query
        
        //empty
        if(!$category) $category = 'all';

        // default
        if($category === 'all') $query_category = '';
        // validate
        else {
            // check
            $id_category = $this->check_exist_cate($category);
            if(!$id_category) die('404 Not Found'); // nếu không tồn tại danh mục đang tìm, n
            else $query_category = ' AND `product`.`CATEGORY` = '.$id_category['id'];
        }

    
        # pagination
        // lấy tổng sản phẩm có áp dụng tìm kiếm
        $count_query = "SELECT COUNT(*) AS total FROM `product` WHERE" . $search_condition . $query_category;
        
        $total_record = mysqli_fetch_assoc(mysqli_query($this->connect, $count_query))['total'];

        // null
        if(!$total_record) die('Sản phẩm không có');
    
        // tính tổng trang
        $total_page = ceil($total_record / $limit_record);
    
        // validate
        if ($page > $total_page || !is_numeric($page) || $page < 1) $page = 1;
    
        // tạo truy vấn phân trang
        $query_paginate = " LIMIT " . (($page - 1) * $limit_record) . ", " . $limit_record;
    
        # main query
        $query = "SELECT 
        `p`.`ID` AS 'id',
        `p`.`name` AS 'name',
        `p`.`price` AS 'price',
        `p`.`IMG_URL` AS 'img',
        `p`.`TOP_PRODUCT` as 'top_seller',
        `c`.`name_category` 
        FROM `product` `p`
        JOIN `category` `c`
        ON `p`.`CATEGORY` = `c`.`ID`
        WHERE ";

        if ($sort_1 == "" && $sort_2 == "") $query .=  $search_condition . $query_category;
        else if ($sort_1 == "featured") $query .= "`p`.`TOP_PRODUCT` = 1 ORDER BY `p`.`TOP_PRODUCT` ASC";
        else if ($sort_1 == "collection") $query .= "1 GROUP BY `p`.`CATEGORY` ORDER BY `p`.`TOP_PRODUCT` ASC";
        else if ($sort_1 == "pname") $query .= $search_condition . $query_category ." ORDER BY `p`.`NAME` ". $sort_2;
        else if ($sort_1 == "price") $query .= $search_condition . $query_category ." ORDER BY `p`.`PRICE` ". $sort_2;
        else die('404 Not Found');

        return [
            'active_category' => $category,
            'active_search' => $search,
            'sort_1' => $sort_1,
            'sort_2' => $sort_2,
            'total_page' => $total_page,
            'active_page' => $page,
            'list' => mysqli_query($this->connect, $query . $query_paginate)
        ];
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
        // Tính tổng giá trị giỏ hàng cho người dùng với ID = $id
        $query = "SELECT SUM(`cart`.`quantity` * `product`.`price`) 
                  FROM `cart`
                  JOIN `product` ON `cart`.`product_id` = `product`.`id`
                  WHERE `cart`.`user_id` = $id AND `cart`.`state` = 1";
    
        return mysqli_query($this->connect, $query);
    }
    
    public function create_product_incart($productId, $userId, $quantity) {
        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $query = "SELECT `ID`, `QUANTITY` FROM `cart` WHERE `UID` = ? AND `PID` = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã có trong giỏ, cập nhật số lượng
            $row = $result->fetch_assoc();
            $newQuantity = $row['QUANTITY'] + $quantity; // Cộng thêm số lượng
            $updateQuery = "UPDATE `cart` SET `QUANTITY` = ? WHERE `ID` = ?";
            $updateStmt = $this->connect->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newQuantity, $row['ID']);
            return $updateStmt->execute();
        } else {
            // Nếu sản phẩm chưa có trong giỏ, thêm mới
            $insertQuery = "INSERT INTO `cart` (`UID`, `PID`, `QUANTITY`, `SIZE`) VALUES (?, ?, ?, 'L')";
            $insertStmt = $this->connect->prepare($insertQuery);
            $insertStmt->bind_param("iii", $userId, $productId, $quantity);
            return $insertStmt->execute();
        }
    }
    
    public function check_account_ban($cmnd) {
        $query = "SELECT `ID` as `id` FROM `ban_account` WHERE `CMND` = '$cmnd';";
        $result = mysqli_query($this->connect, $query);
    
        if (!$result) {
            die("Error in query: " . mysqli_error($this->connect)); // Debug error if query fails
        }
    
        return $result;
    }
    
    public function check_account_inside($cmnd, $mail) {
        $query = "SELECT `ID` as `id` FROM `account` WHERE `EMAIL` = '$mail' OR `CMND` = '$cmnd';";
        $result = mysqli_query($this->connect, $query);
    
        if (!$result) {
            die("Error in query: " . mysqli_error($this->connect)); // Debug error if query fails
        }
    
        return $result;
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