<?php
class ProductController extends Controller {
    public function list($user, $sort_1 = "", $sort_2 = "") {
        $cus = $this->model($user);
        $this->view("Products", [
            "cate" => $cus->get_product_cates(),
            "product" => $cus->get_products($sort_1, $sort_2),
            "user" => $user
        ]);
    }

    public function detail($user, $pid) {
        $cus = $this->model($user);
        $comment = $cus->get_item_comment($pid[2], "");
        $cmt_info = [];

        foreach ($comment as $cmt) {
            $cmt_info[] = [
                "id" => $cmt["id"],
                "pid" => $cmt["pid"],
                "uid" => $cmt["uid"],
                "uname" => $cus->get_cmt_user_name($cmt["uid"]),
                "star" => $cmt["star"],
                "content" => $cmt["content"],
                "time" => $cmt["time"]
            ];
        }

        $this->view("Item", [
            "product_id" => $cus->get_product_at_id($pid[2]),
            "sub_img" => $cus->get_sub_img($pid[2]),
            "cate_product" => $cus->get_product_same_cate($pid[2]),
            "comment" => $cmt_info,
            "user" => $user
        ]);
    }
}
?>
