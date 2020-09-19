<?php
class Book
{
    var $book_id;
    var $name;
    var $description;
    var $quantity;
    var $price;
    var $date;
    var $image;
    var $status;
    var $author_id;
    var $category_id;
    var $publisher_id;
    var $coupon_id;

    public function __construct($book_id, $name, $description, $quantity, $price, $date, $image, $status, $author_id, $category_id, $publisher_id, $coupon_id)
    {
        $this->book_id = $book_id;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = $date;
        $this->image = $image;
        $this->status = $status;
        $this->author_id = $author_id;
        $this->category_id = $category_id;
        $this->publisher_id = $publisher_id;
        $this->coupon_id = $coupon_id;
    }

    public static function get_all_books()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_book Where status = 1") as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    
    public static function sort_date($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  $book->date;
            }
        }
        arsort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }

    public static function sort_rate($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  Rating::average_score_of_a_book($book->book_id);
            }
        }
        arsort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }

    public static function sort_sale($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  Coupon::get_coupon_of_a_book($book->book_id);
            }
        }
        arsort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }

    public static function sort_sell($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  count(OrderDetails::get_sell($book->book_id));
            }
        }
        arsort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }

    public static function sort_name($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  $book->name;
            }
        }
        asort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }

    public static function sort_none($book_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($book_list as $book) {
            if ($book->book_id != null) {
                $data[$book->book_id] =  $book->name;
            }
        }
        $array_key = array_keys($data);
        $total = count($array_key);
        $books = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($books, Book::get_a_book($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $books;
    }
    public static function get_data_according_to_publisher($publisher_id)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE publisher_id = ? AND status = 1");
        $stmt->execute([$publisher_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }
    public static function get_data_according_to_sale_off()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 1 AND coupon_id IS NOT NULL");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function get_data_of_coupon($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 1 AND coupon_id = ?");
        $stmt->execute([$request]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_of_each_publisher()
    {
        $data = [];
        foreach (Publisher::get_all_data() as $publisher) {
            array_push($data, array($publisher->publisher_id => count(Book::get_data_according_to_publisher($publisher->publisher_id))));
        }
        return $data;
    }

    public static function get_data_according_to_author($author_id)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE author_id = ? AND status = 1");
        $stmt->execute([$author_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_of_each_author()
    {
        $data = [];
        foreach (Author::get_all_data() as $author) {
            array_push($data, array($author->author_id => count(Book::get_data_according_to_author($author->author_id))));
        }
        return $data;
    }

    public static function get_data_according_to_category($category_id)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE category_id = ? AND status = 1");
        $stmt->execute([$category_id]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function count_book_of_each_category()
    {
        $data = [];
        foreach (Category::get_all_data() as $category) {
            array_push($data, array($category->category_id => count(Book::get_data_according_to_category($category->category_id))));
        }
        return $data;
    }

    public static function get_a_book($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE book_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $book = new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
        return $book;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_book WHERE status = 0");
        $stmt->execute();
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Book($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]));
        }
        return $data;
    }

    public static function check_out($demand, $book_id)
    {
        $data = Book::get_a_book($book_id);
        if ($data->quantity <= $demand) {
            return false;
        } else {
            return true;
        }
    }

    public static function get_all_carts()
    {
        $data = [];
        if (isset($_SESSION["user"])) {
            $cart = Cart::get_all_carts();
            foreach ($cart as $row) {
                array_push($data, Book::get_a_book($row->book_id));
            }
        }
        return $data;
    }

    public static function get_all_comments($request)
    {
        $data = [];
        $array = [];
        foreach (Comment::get_all_comments_of_an_user($request) as $comment) {
            array_push($array, $comment->book_id);
        }
        foreach (array_unique($array) as $id) {
            array_push($data, Book::get_a_book($id));
        }
        return $data;
    }

    public static function get_all_carts_coupons()
    {
        $data = [];
        foreach (Book::get_all_carts() as $book) {
            array_push($data, array($book->book_id => Coupon::get_coupon_of_a_book($book->book_id)));
        }
        return $data;
    }

    public static function get_order_details($request)
    {
        $data = [];
        foreach (OrderDetails::get_order_details($request) as $order) {
            array_push($data, Book::get_a_book($order->book_id));
        }
        return $data;
    }

    public static function check_status_of_a_book($book_id)
    {
        $book = Book::get_a_book($book_id);
        if ($book->status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function modify_quantity($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET quantity = quantity + ?  WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["quantity"], $request["book_id"]]);
    }

    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_book (name,description,quantity,price,date,image,status,author_id,category_id,publisher_id,coupon_id) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["quantity"], $request["price"], $request["date"], $request["image"], 1, $request["author_id"], $request["category_id"], $request["publisher_id"], $request["coupon_id"]]);
    }

    public static function update($request)
    {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET name = ? , description = ? , quantity = ? , price = ? , date = ? , image = ? , author_id = ? , category_id = ? , publisher_id = ? , coupon_id = ? WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["quantity"], $request["price"], $date, $request["image"], $request["author_id"], $request["category_id"], $request["publisher_id"], $request["coupon_id"], $request["book_id"]]);
    }

    public static function do_remove($request) {
        $book = Book::get_a_book($request);
        if ($book->quantity > 0) {
            return $book->name.": there are " .$book->quantity." books left in the store; ";
        }
        else {
            $count_order = null;
            foreach (Order::get_all_undone_orders() as $order) {
                foreach (OrderDetails::get_order_details($order->order_id) as $order_details) {
                    if ($order_details->book_id == $book->book_id) {
                        $count_order = $count_order + 1;
                    }
                }
            }
            if ($count_order > 0) {
                return $book->name.": there are " .$count_order." relating undone orders.; ";
            }
            else {
                Book::remove($request);
            }
        }
    }
    public static function do_delete($request) {
        $book = Book::get_a_book($request);
        if ($book->quantity > 0) {
            return $book->name.": there are " .$book->quantity." books left in the store; ";
        }
        else {
            $count_order = null;
            foreach (Order::get_all_done_orders() as $order) {
                foreach (OrderDetails::get_order_details($order->order_id) as $order_details) {
                    if ($order_details->book_id == $book->book_id) {
                        $count_order = $count_order + 1;
                    }
                }
            }
            if ($count_order > 0) {
                return $book->name.": there are " .$count_order." relating done orders.; ";
            }
            else {
                Book::remove($request);
            }
        }
    }
    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET status = 0 WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_book SET status = 1 WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_book WHERE book_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
