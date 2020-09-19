<?php
class HomeController extends Controller
{
    public function index()
    {
        $newest_books = Book::sort_date(Book::get_all_books(),0,4);
        $best_sell_books = Book::sort_sell(Book::get_all_books(),0,4);
        $recommend_books = Book::sort_rate(Book::get_all_books(),0,4);
        $news = News::sort_date(News::get_all_data(),0,4);
        $cart = null;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "main_page.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "most_sale" => $best_sell_books,
                "most_rate" =>  $recommend_books,
                "newest_update" => $newest_books,
                "coupons" => Coupon::get_all_data(),
                "news" => $news,
            ]
        );
        $this->view->render();

    }

    public function news()
    {
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $number_of_record_per_page = 12;
        $news = News::get_all_data();
        $start_record = ($current_page - 1) * $number_of_record_per_page;
        $number_of_record = count($news);
        $number_of_page = ceil($number_of_record / $number_of_record_per_page);
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "news_display.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "news" => News::sort_date(News::get_all_data(), $start_record, $number_of_record_per_page),
                "page" => $current_page,
                "number_of_page" => $number_of_page,
            ]
        );
        $this->view->render();
    }

    public function news_details()
    {
        $news_id = isset($_GET["id"]) ? $_GET["id"] : 1;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "news_details.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts(),
                "news" => News::get_a_news($news_id),
            ]
        );
        $this->view->render();
    }

    public function introduction()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "introduction.php",
                "categories" => Category::get_all_data(),
                "authors" => Author::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }
}
