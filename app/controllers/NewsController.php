<?php
class NewsController extends Controller {
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
                "shortcontent" => $snews["short_content"]
            ];
        }

        $this->view("News", [
            "news" => $news_list,
            "user" => $user
        ]);
    }

    public function detail($user, $params) {
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

        $this->view("News_detail", [
            "news" => $news_list,
            "user" => $user,
            "params" => $params[2]
        ]);
    }
}
?>
