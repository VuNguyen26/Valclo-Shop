<?php
class HomeController extends Controller {
    public function index($user) {
        $cus = $this->model($user);
        $news = $cus->get_news();
        $news_list = [];

        foreach ($news as $snews) {
            $news_list[] = [
                "id" => $snews["id"],
                "cid" => $snews["cid"],
                "key" => $snews["key"],
                "time" => $snews["time"],
                "title" => $snews["title"],
                "content" => $snews["content"],
                "imgurl" => $snews["img_url"],
                "shortcontent" => $snews["short_content"],
                "comment" => $cus->get_comment_news($snews["id"])
            ];
        }

        $this->view("Home_page", [
            "user" => $user,
            "news" => $news_list,
            "collection" => $cus->get_swiper_slide_collection(),
            "featured" => $cus->get_products("", "")
        ]);
    }

    public function about() {
        $this->view("About_US", []);
    }
}
?>
