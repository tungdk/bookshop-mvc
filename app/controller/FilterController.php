<?php
class FilterController extends Controller
{
    public function index()
    {
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "error.php",
            ]
        );
        $this->view->render();
    }

    public function according_to_category()
    {
        $category_id =  isset($_GET["id"]) ? $_GET["id"] : 1;
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : "none";
        $number_of_book_per_page = 12;
        $data = Book::get_data_according_to_category($category_id);
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = count($data);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $books = null;
        switch ($sort) {
            case "none":
                $books = Book::sort_none($data, $start_record, $number_of_book_per_page);
                break;
            case "name":
                $books = Book::sort_name($data, $start_record, $number_of_book_per_page);

                break;
            case "sale":
                $books = Book::sort_sale($data, $start_record, $number_of_book_per_page);

                break;
            case "sell":
                $books = Book::sort_sell($data, $start_record, $number_of_book_per_page);

                break;
            case "date":
                $books = Book::sort_date($data, $start_record, $number_of_book_per_page);
                break;
            case "rate":
                $books = Book::sort_rate($data, $start_record, $number_of_book_per_page);
                break;
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_category.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_category" => Book::count_book_of_each_category(),
                "selected_category" => Category::get_category_for_filter($category_id),
                "books" => $books,
                "page" => $current_page,
                "category_id" => $category_id,
                "number_of_page" => $number_of_page,
                "sort" => $sort,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function according_to_author()
    {
        $author_id =  isset($_GET["id"]) ? $_GET["id"] : 1;
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : "none";
        $number_of_book_per_page = 12;
        $data = Book::get_data_according_to_author($author_id);
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = count($data);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $books = null;
        switch ($sort) {
            case "none":
                $books = Book::sort_none($data, $start_record, $number_of_book_per_page);
                break;
            case "name":
                $books = Book::sort_name($data, $start_record, $number_of_book_per_page);
                break;
            case "date":
                $books = Book::sort_date($data, $start_record, $number_of_book_per_page);
                break;
            case "sale":
                $books = Book::sort_sale($data, $start_record, $number_of_book_per_page);
                break;
            case "sell":
                $books = Book::sort_sell($data, $start_record, $number_of_book_per_page);
                break;
            case "rate":
                $books = Book::sort_rate($data, $start_record, $number_of_book_per_page);
                break;
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_author.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_author" => Book::count_book_of_each_author(),
                "selected_author" => Author::get_author_for_filter($author_id),
                "books" => $books,
                "page" => $current_page,
                "category_id" => $author_id,
                "number_of_page" => $number_of_page,
                "sort" => $sort,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }

    public function according_to_publisher()
    {
        $publisher_id =  isset($_GET["id"]) ? $_GET["id"] : 1;
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : "none";
        $number_of_book_per_page = 12;
        $data = Book::get_data_according_to_publisher($publisher_id);
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = count($data);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $books = null;
        switch ($sort) {
            case "none":
                $books = Book::sort_none($data, $start_record, $number_of_book_per_page);
                break;
            case "date":
                $books = Book::sort_date($data, $start_record, $number_of_book_per_page);
                break;
            case "name":
                $books = Book::sort_name($data, $start_record, $number_of_book_per_page);
                break;
            case "sale":
                $books = Book::sort_sale($data, $start_record, $number_of_book_per_page);
                break;
            case "sell":
                $books = Book::sort_sell($data, $start_record, $number_of_book_per_page);

                break;
            case "rate":
                $books = Book::sort_rate($data, $start_record, $number_of_book_per_page);
                break;
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "filter_publisher.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "count_book_of_each_publisher" => Book::count_book_of_each_publisher(),
                "selected_publisher" => publisher::get_publisher_for_filter($publisher_id),
                "books" => $books,
                "page" => $current_page,
                "category_id" => $publisher_id,
                "number_of_page" => $number_of_page,
                "sort" => $sort,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }
    public function sort()
    {
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : "none";
        $number_of_book_per_page = 12;
        $data = Book::get_all_books();
        $start_record = ($current_page - 1) * $number_of_book_per_page;
        $number_of_book = count($data);
        $number_of_page = ceil($number_of_book / $number_of_book_per_page);

        $books = null;
        $sort_type = null;
        switch ($sort) {
            case "none":
                $books = Book::sort_none($data, $start_record, $number_of_book_per_page);
                $sort_type = "None";
                break;
            case "date":
                $books = Book::sort_date($data, $start_record, $number_of_book_per_page);
                $sort_type = "Update date";
                break;
            case "name":
                $books = Book::sort_name($data, $start_record, $number_of_book_per_page);
                $sort_type = "A to Z";
                break;
            case "sale":
                $books = Book::sort_sale($data, $start_record, $number_of_book_per_page);
                $sort_type = "Sale off ";
                break;
            case "sell":
                $books = Book::sort_sell($data, $start_record, $number_of_book_per_page);
                $sort_type = "Most sell";
                break;
            case "rate":
                $books = Book::sort_rate($data, $start_record, $number_of_book_per_page);
                $sort_type = "Rating";
                break;
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "index.php",
            [
                "component" => "sort_page.php",
                "categories" => Category::get_all_data(),
                "publishers" => Publisher::get_all_data(),
                "books" => $books,
                "page" => $current_page,
                "number_of_page" => $number_of_page,
                "sort" => $sort,
                "sort_type" => $sort_type,
                "authors" => Author::get_all_data(),
                "coupons" => Coupon::get_all_data(),
                "total_cost" => Cart::get_total_cost(),
                "get_all_carts" => Book::get_all_carts()
            ]
        );
        $this->view->render();
    }
    public function according_to_search_name()
    {
        if (!isset($_GET["search_name"])) {
            header("location: /Bookshop/");
        } else {
            $request = $_GET;
            $search_name = $request["search_name"];
            $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
            $number_of_book_per_page = 12;
            $start_record = ($current_page - 1) * $number_of_book_per_page;
            $data = Book::get_data_according_to_search_name($search_name);
            $number_of_book = count($data);
            $number_of_page = ceil($number_of_book / $number_of_book_per_page);
            $this->view(
                "customer" . DIRECTORY_SEPARATOR . "index.php",
                [
                    "component" => "filter_search.php",
                    "categories" => Category::get_all_data(),
                    "publishers" => Publisher::get_all_data(),
                    "books" => Book::sort_none($data,$start_record,$number_of_book_per_page),
                    "page" => $current_page,
                    "search_name" => $search_name,
                    "count_book_according_to_search_name" => count(Book::get_data_according_to_search_name($search_name)),
                    "page" => $current_page,
                    "number_of_page" => $number_of_page,
                    "authors" => Author::get_all_data(),
                    "coupons" => Coupon::get_all_data(),
                    "total_cost" => Cart::get_total_cost(),
                    "get_all_carts" => Book::get_all_carts()
                ]
            );
            $this->view->render();
        }
    }

    public function live_search()
    {
        $request = $_GET;
        $message = "";
        if ($request["search_name"] != "" || $request["search_name"] != null) {
            $data = Book::get_data_according_to_search_name($request["search_name"]);
            // $message = '<div style="height:100px;overflow:auto;">';
            foreach ($data as $book) {
                $message .=    '<li class="list-group-item">
                                <a href="/DoAnTH02/Details/index/id=' . $book->book_id . '">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img style="float:left;width:50px;height:70px;" src="' . $book->image . '">
                                        </div>
                                        <div class="col-md-9">
                                            <p class="text-primary">' . $book->name . '</p>
                                            <p class="text-danger">Price :' . $book->price . '<small> vnd</small></p>
                                        </div>
                                    </div>
                                </a>
                            </li>';
            }
            // $message = '</div>';
        }
        $this->view(
            "customer" . DIRECTORY_SEPARATOR . "test.php",
            [
                "message" => $message,
            ]
        );
        $this->view->render();
    }
}
