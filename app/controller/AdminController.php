<?php
class AdminController extends Controller
{

    public function index()
    {
        if (isset($_SESSION["admin"])) {
            $search_year = isset($_GET["search_year"]) ? $_GET["search_year"] : date("yy");
            $this->view(
                "admin" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "report" . DIRECTORY_SEPARATOR . "report.php",
                    "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                    "report_chart" => Order::report_chart($search_year),
                    "year" => $search_year,
                    "books" => Book::get_all_books(),
                    "news" => News::get_all_data(),
                    "comments" => Comment::get_all_first_comments(),
                    "orders" => Order::get_all_undone_orders(),
                ]
            );
            $this->view->render();
        } else {
            header("location: /Bookshop/Admin/administrator/?action=login");
        }
    }
    public function book()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Book::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_management.php",
                            "books" => Book::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_add.php",
                            "authors" => Author::get_all_data(),
                            "publishers" => Publisher::get_all_data(),
                            "coupons" => Coupon::get_all_data(),
                            "categories" => Category::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    if ($_POST["coupon_id"] == "" || $_POST["coupon_id"] == null) {
                        $request["coupon_id"] = null;
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Book::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {
                    $book_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_update.php",
                            "book" => Book::get_a_book($book_id),
                            "authors" => Author::get_all_data(),
                            "publishers" => Publisher::get_all_data(),
                            "coupons" => Coupon::get_all_data(),
                            "categories" => Category::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    if ($request["image"] == null) {
                        $request["image"] = $request["current_image"];
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Book::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Book::do_remove($request["book_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Book::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any product to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Book::do_delete($request["book_id"]),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Book::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_restore.php",
                            "books" => Book::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Book::restore($request["book_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "import":
                if (isset($_SESSION["admin"])) {
                    $import_number = isset($_POST["import_number"]) ? $_POST["import_number"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_import.php",
                            "import_number" => $import_number,
                            "books" => Book::get_all_books(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_import":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = null;
                    for ($n = 0; $n < $request["import_number"]; $n++) {
                        $request["book_id"] = $request["book_id$n"];
                        $request["quantity"] = $request["quantity$n"];
                        $message = Book::modify_quantity($request);
                        $request["book_id"] = null;
                        $request["quantity"] = null;
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {

                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Book::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "book" . DIRECTORY_SEPARATOR . "book_management.php",
                            "books" => Book::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }

    public function category()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Category::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "category" . DIRECTORY_SEPARATOR . "category_management.php",
                            "categories" => Category::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {

                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "category" . DIRECTORY_SEPARATOR . "category_add.php",
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Category::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {

                    $category_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "category" . DIRECTORY_SEPARATOR . "category_update.php",
                            "category" => Category::get_category_for_filter($category_id),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Category::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Category::do_remove($request["category_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Category::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any category to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Category::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "category" . DIRECTORY_SEPARATOR . "category_restore.php",
                            "categories" => Category::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Category::restore($request["category_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Category::delete($request["category_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Category::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "category" . DIRECTORY_SEPARATOR . "category_management.php",
                            "categories" => Category::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }

    public function author()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Author::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "author" . DIRECTORY_SEPARATOR . "author_management.php",
                            "authors" => Author::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "author" . DIRECTORY_SEPARATOR . "author_add.php",
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Author::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {
                    $author_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "author" . DIRECTORY_SEPARATOR . "author_update.php",
                            "author" => Author::get_author_for_filter($author_id),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Author::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Author::do_remove($request["author_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Author::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any author to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Author::delete($request["author_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Author::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "author" . DIRECTORY_SEPARATOR . "author_restore.php",
                            "authors" => Author::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Author::restore($request["author_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Author::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "author" . DIRECTORY_SEPARATOR . "author_management.php",
                            "authors" => Author::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }

    public function publisher()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Publisher::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_management.php",
                            "publishers" => Publisher::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_add.php",
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Publisher::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {

                    $publisher_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_update.php",
                            "publisher" => Publisher::get_publisher_for_filter($publisher_id),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Publisher::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Publisher::do_remove($request["publisher_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Publisher::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any publisher to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Publisher::delete($request["publisher_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Publisher::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_restore.php",
                            "publishers" => Publisher::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Publisher::restore($request["publisher_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {

                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 5;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Publisher::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "publisher" . DIRECTORY_SEPARATOR . "publisher_management.php",
                            "publishers" => Publisher::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function coupon()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Coupon::get_all_data();
                    $number_of_record = count(Coupon::get_all_data());
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_management.php",
                            "coupons" => Coupon::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {

                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_add.php",
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Coupon::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {

                    $coupon_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_update.php",
                            "coupon" => Coupon::get_a_coupon($coupon_id),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Coupon::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Coupon::do_remove($request["coupon_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Coupon::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any product to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Coupon::delete($request["coupon_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {

                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Coupon::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_restore.php",
                            "coupons" => Coupon::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Coupon::restore($request["coupon_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {

                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Coupon::get_all_data();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "coupon" . DIRECTORY_SEPARATOR . "coupon_management.php",
                            "coupons" => Coupon::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function user()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = User::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "user" . DIRECTORY_SEPARATOR . "user_management.php",
                            "users" => User::sort_none($data, $start_record, $number_of_record_per_page),
                            "wards" => Ward::get_all_data(),
                            "districts" => District::get_all_data(),
                            "provinces" => Province::get_all_data(),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {

                    $user_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "user" . DIRECTORY_SEPARATOR . "user_details.php",
                            "user" => User::get_an_user($user_id),
                            "wards" => Ward::get_all_data(),
                            "districts" => District::get_all_data(),
                            "provinces" => Province::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = User::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "user" . DIRECTORY_SEPARATOR . "user_restore.php",
                            "users" => User::sort_none($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => User::restore($request["user_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => User::do_remove($request["user_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= User::do_remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any user to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_grant_rights":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => User::grant_right_for_user($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = User::get_all_data();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "user" . DIRECTORY_SEPARATOR . "user_management.php",
                            "users" => User::sort_none($data, $start_record, $number_of_record_per_page),
                            "wards" => Ward::get_all_data(),
                            "districts" => District::get_all_data(),
                            "provinces" => Province::get_all_data(),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function order()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Order::get_all_undone_orders();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "order" . DIRECTORY_SEPARATOR . "order_management.php",
                            "orders" => Order::sort_date($data, $start_record, $number_of_record_per_page),
                            "users" => User::get_all_data(),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "details":
                if (isset($_SESSION["admin"])) {

                    $order_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "order" . DIRECTORY_SEPARATOR . "order_details.php",
                            "categories" => Category::get_all_data(),
                            "publishers" => Publisher::get_all_data(),
                            "authors" => Author::get_all_data(),
                            "total_cost" => Cart::get_total_cost(),
                            "get_all_carts" => Book::get_all_carts(),
                            "users" => User::get_all_data(),
                            "order" => Order::get_an_order($order_id),
                            "order_details" => OrderDetails::get_order_details($order_id),
                            "book_order_details" => Book::get_order_details($order_id),
                            "coupons" => Coupon::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "history":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Order::get_all_done_orders();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "order" . DIRECTORY_SEPARATOR . "order_history.php",
                            "orders" => Order::sort_date($data, $start_record, $number_of_record_per_page),
                            "users" => User::get_all_data(),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Order::do_delete_order($request["order_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_process_order":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Order::process_order($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Order::get_all_undone_orders();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "order" . DIRECTORY_SEPARATOR . "order_management.php",
                            "orders" => Order::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function comment()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Comment::get_all_comments();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                            "books" => Book::get_all_books(),
                            "comments" => Comment::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "reply":
                if (isset($_SESSION["admin"])) {
                    $comment_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $comment = Comment::get_a_comment($comment_id);
                    $book_id = $comment->book_id;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "comment" . DIRECTORY_SEPARATOR . "comment_reply.php",
                            "comment" => $comment,
                            "book" => Book::get_a_book($book_id),
                            "authors" => Author::get_all_data(),
                            "publishers" => Publisher::get_all_data(),
                            "coupons" => Coupon::get_all_data(),
                            "categories" => Category::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_reply":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Comment::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Comment::remove($request["comment_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= Comment::remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any product to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Comment::get_all_comments_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "comment" . DIRECTORY_SEPARATOR . "comment_restore.php",
                            "books" => Book::get_all_books(),
                            "comments" => Comment::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => Comment::restore($request["comment_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = Comment::get_all_comments();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                            "books" => Book::get_all_books(),
                            "comments" => Comment::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function news()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $search_name = isset($_GET["search_name"]) ? $_GET["search_name"] : "";
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = News::get_data_according_to_search_name($search_name);
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "news" . DIRECTORY_SEPARATOR . "news_management.php",
                            "news" => News::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "add":
                if (isset($_SESSION["admin"])) {

                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "news" . DIRECTORY_SEPARATOR . "news_add.php",
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),

                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_add":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => News::insert($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "update":
                if (isset($_SESSION["admin"])) {
                    $news_id = isset($_GET["id"]) ? $_GET["id"] : 1;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "news" . DIRECTORY_SEPARATOR . "news_update.php",
                            "news" => News::get_a_news($news_id),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    if ($request["image"] == null) {
                        $request["image"] = $request["current_image"];
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => News::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => News::remove($request["news_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_mass_remove":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $message = "";
                    if (!empty($request["mass_remove_list"])) {
                        foreach ($request["mass_remove_list"] as $remove_list) {
                            $message .= News::remove($remove_list);
                        }
                    } else {
                        $message = "You have yet selected any product to delete.";
                    }
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => $message,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_delete":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => News::delete($request["news_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "restore":
                if (isset($_SESSION["admin"])) {

                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = News::get_data_for_restore();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "news" . DIRECTORY_SEPARATOR . "news_restore.php",
                            "news" => News::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_restore":
                if (isset($_SESSION["admin"])) {

                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => News::restore($request["news_id"]),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            default:
                if (isset($_SESSION["admin"])) {

                    $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
                    $number_of_record_per_page = 10;
                    $start_record = ($current_page - 1) * $number_of_record_per_page;
                    $data = News::get_all_data();
                    $number_of_record = count($data);
                    $number_of_page = ceil($number_of_record / $number_of_record_per_page);
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "comment" . DIRECTORY_SEPARATOR . "comment_management.php",
                            "news" => News::sort_date($data, $start_record, $number_of_record_per_page),
                            "page" => $current_page,
                            "number_of_page" => $number_of_page,
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
    public function administrator()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        switch ($action) {
            case "index":
                if (isset($_SESSION["admin"])) {
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "admin" . DIRECTORY_SEPARATOR . "admin_details.php",
                            "user" => User::get_an_user($_SESSION["admin"]["id"]),
                            "wards" => Ward::get_all_data(),
                            "districts" => District::get_all_data(),
                            "provinces" => Province::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_update":
                if (isset($_SESSION["admin"])) {
                    $request = $_POST;
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "test.php",
                        [
                            "message" => User::update($request),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "do_logout":
                if (isset($_SESSION["admin"])) {
                    User::do_logout();
                    header("location: /Bookshop/Admin/");
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
            case "login":
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "admin/admin_login.php",
                    []
                );
                $this->view->render();
                break;
            case "do_login":
                $request = $_POST;
                $this->view(
                    "admin" . DIRECTORY_SEPARATOR . "test.php",
                    [
                        "message" => User::admin_do_login($request),
                    ]
                );
                $this->view->render();
                break;
            default:
                if (isset($_SESSION["admin"])) {
                    $this->view(
                        "admin" . DIRECTORY_SEPARATOR . "index.php",
                        [
                            "component" => "admin" . DIRECTORY_SEPARATOR . "admin_details.php",
                            "user" => User::get_an_user($_SESSION["user"]["id"]),
                            "wards" => Ward::get_all_data(),
                            "districts" => District::get_all_data(),
                            "provinces" => Province::get_all_data(),
                            "count_all_undone_orders" => count(Order::get_all_undone_orders()),
                        ]
                    );
                    $this->view->render();
                } else {
                    header("location: /Bookshop/Admin/administrator/?action=login");
                }
                break;
        }
    }
}
