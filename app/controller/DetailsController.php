<?php
class DetailsController extends Controller
{

    public function index()
    {
        $book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : 1;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "customer" . DIRECTORY_SEPARATOR . "details.php",
                "book" => Book::get_a_book($book_id),
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "average_score" => Rating::average_score_of_a_book($book_id),
                "all_rating_reviews" => Rating::count_all_reviews_of_a_book($book_id),
                "comments" => Comment::get_all_comments_of_a_book($book_id),
                "users" => User::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "display_comments" => Comment::display_all_comments($book_id),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function add_comment()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $message = null;
            $request["user_id"] = $_SESSION["user"]["id"];
            $request["comment_id"] = Comment::add_comment($request);
            $message .= Rating::insert($request);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => $message,
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                ]
            );
        }
        $this->view->render();
    }
}
