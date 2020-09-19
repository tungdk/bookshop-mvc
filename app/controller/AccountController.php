<?php
class AccountController extends Controller
{
    public function index()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_imformation.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "province" => Province::get_all_data(),
                    "district" => District::get_all_data(),
                    "ward" => Ward::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }
    public function do_change_imformation()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::update($request),
            ]
        );
        $this->view->render();
    }

    public function login()
    {
        if (!isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "login.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        } else {
            header("Location: /Bookshop/");
        }
        $this->view->render();
    }

    public function do_login()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::do_login($request),
            ]
        );
        $this->view->render();
    }

    public function do_logout()
    {
        User::do_logout();
        header("Location: /Bookshop/");
    }

    public function register()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "register.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "authors" => Author::get_all_data(),
                "province" => Province::get_all_data(),
                "district" => District::get_all_data(),
                "ward" => Ward::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function do_register()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => User::do_register($request),
            ]
        );
        $this->view->render();
    }

    public function get_district()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "get_district.php",
            [
                "all_districts" => District::get_all_district_of_a_province($request["province_id"]),
            ]
        );
        $this->view->render();
    }

    public function get_ward()
    {
        $request = $_POST;
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "get_ward.php",
            [
                "all_wards" => Ward::get_all_wards_of_a_district($request["district_id"]),
            ]
        );
        $this->view->render();
    }

    public function order_list()
    {
        if (isset($_SESSION["user"])) {
            $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $number_of_record_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_record_per_page;
            $data = Order::get_all_undone_orders_each_customer($_SESSION["user"]["id"]);
            $number_of_order = count($data);
            $number_of_page = ceil($number_of_order / $number_of_record_per_page);

            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_order.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "orders" => Order::sort_date($data,$start_record,$number_of_record_per_page),
                    "page" => $current_page,
                    "number_of_page" => $number_of_page,
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

    public function order_details()
    {
        if (isset($_SESSION["user"])) {
            $id = isset($_GET["id"]) ? $_GET["id"] : 1;
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_order_details.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "order" => Order::get_an_order($id),
                    "order_details" => OrderDetails::get_order_details($id),
                    "book_order_details" => Book::get_order_details($id),
                    "coupons" => Coupon::get_all_data()
                ]
            );
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }

    public function do_delete_order()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $message = null;
            $order = Order::get_an_order($request["order_id"]);
            if ($order->status < 1) {
                $message = Order::do_delete_order($request["order_id"]);
            }
            else {
                $message = "Your order is in process, you could no longer delete your order";
            }
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => $message,
                ]
            );
            $this->view->render();
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
            $this->view->render();
        }
    }

    public function transaction_history()
    {
        if (isset($_SESSION["user"])) {
            $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $number_of_order_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_order_per_page;
            $data = Order::get_all_done_orders_each_customer($_SESSION["user"]["id"]);
            $number_of_order = count($data);
            $number_of_page = ceil($number_of_order / $number_of_order_per_page);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_history.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "orders" => Order::sort_date($data, $start_record, $number_of_order_per_page),
                    "page" => $current_page,
                    "number_of_page" => $number_of_page,
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

    public function comment_list()
    {
        if (isset($_SESSION["user"])) {
            $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $number_of_record_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_record_per_page;
            $data = Comment::get_all_comments_of_an_user($_SESSION["user"]["id"]);
            $number_of_record = count($data);
            $number_of_page = ceil($number_of_record / $number_of_record_per_page);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_comment.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts(),
                    "comments" => Comment::sort_date($data, $start_record, $number_of_record_per_page),
                    "books" => Book::get_all_comments($_SESSION["user"]["id"]),
                    "number_of_page" => $number_of_page,
                    "page" => $current_page
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

    public function change_password()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "personal_change_password.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
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

    public function do_change_password()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => User::change_password($request),
                ]
            );
            $this->view->render();
        } else {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "error.php",
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
        }
        $this->view->render();
    }
}
