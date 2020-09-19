<?php
class ShoppingController extends Controller
{
    public function index()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "customer" . DIRECTORY_SEPARATOR . "details_cart.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "users" => User::get_all_data(),
                    "coupons" => Coupon::get_all_data(),
                    "get_all_carts_books" => Book::get_all_carts(),
                    "get_all_carts" => Cart::get_all_carts(),
                    "get_total_cost" => Cart::get_total_cost(),
                    "get_all_carts_coupons" => Book::get_all_carts_coupons(),
                    "total_cost" => Cart::get_total_cost(),
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

    public function add_to_cart()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => Cart::add_to_cart($request["book_id"]),
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

    public function do_change_quantity()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => Cart::change_quantity($request),
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

    public function do_delete_cart()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => Cart::do_delete_cart($request["book_id"]),
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

    public function check_out()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => Cart::check_out(),
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

    public function confirm_order()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" =>  "confirm_order.php",
                    "province" => Province::get_all_data(),
                    "district" => District::get_all_data(),
                    "ward" => Ward::get_all_data(),
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "users" => User::get_all_data(),
                    "coupons" => Coupon::get_all_data(),
                    "get_all_carts_books" => Book::get_all_carts(),
                    "get_all_carts" => Cart::get_all_carts(),
                    "get_total_cost" => Cart::get_total_cost(),
                    "get_all_carts_coupons" => Book::get_all_carts_coupons(),
                    "current_user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
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

    public function do_order()
    {
        if (isset($_SESSION["user"])) {
            $request = $_POST;
            $ward = Ward::get_a_ward($request["ward_id"])->name;
            $district = District::get_a_district($request["district_id"])->name;
            $province = Province::get_a_province($request["province_id"])->name;
            $request["address"] = $_POST["address"] . ", " . $ward . ", " . $district . ", " . $province;

            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "test.php",
                [
                    "message" => Order::insert($request),
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
    public function success_order()
    {
        if (isset($_SESSION["user"])) {
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" =>  "successful_order.php",
                    "province" => Province::get_all_data(),
                    "district" => District::get_all_data(),
                    "ward" => Ward::get_all_data(),
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "authors" => Author::get_all_data(),
                    "users" => User::get_all_data(),
                    "coupons" => Coupon::get_all_data(),
                    "get_all_carts_books" => Book::get_all_carts(),
                    "get_all_carts" => Cart::get_all_carts(),
                    "get_total_cost" => Cart::get_total_cost(),
                    "get_all_carts_coupons" => Book::get_all_carts_coupons(),
                    "current_user" => User::get_an_user($_SESSION["user"]["id"]),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
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
}
