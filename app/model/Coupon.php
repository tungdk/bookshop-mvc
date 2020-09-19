<?php
class Coupon
{
    var $coupon_id;
    var $content;
    var $status;

    public function __construct($coupon_id, $content, $status)
    {
        $this->coupon_id = $coupon_id;
        $this->content = $content;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_coupon WHERE status = 1") as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }


    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_coupon WHERE status = 0") as $row) {
            array_push($data, new Coupon($row[0], $row[1], $row[2]));
        }
        return $data;
    }

    public static function get_a_coupon($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $coupon = new Coupon($row[0], $row[1], $row[2]);
        return $coupon;
    }

    public static function get_coupon_of_a_book($request)
    {
        $book = Book::get_a_book($request);
        $coupon = Coupon::get_a_coupon($book->coupon_id);
        if ($coupon != null)
            return $coupon->content;
        else
            return 0;
    }

    public static function get_coupon_list() {
        $data = [];
        foreach (Book::get_all_books() as $book) {
            $data[$book->book_id] = Coupon::get_coupon_of_a_book($book->book_id);
        }
        return $data;
    }

    public static function sort_none($coupon_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($coupon_list as $coupon) {
            if ($coupon->coupon_id != null) {
                $data[$coupon->coupon_id] =  $coupon->content;
            }
        }
        $array_key = array_keys($data);
        $total = count($array_key);
        $coupons = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($coupons, Coupon::get_a_coupon($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $coupons;
    }

    public static function insert($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_coupon (content,status) VALUES (?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["content"], 1]);
    }

    public static function update($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET content = ?  WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["content"] ,$request["coupon_id"]]);
    }

    public static function do_remove($request) {
        $data = Book::get_data_of_coupon($request);
        if (count($data) > 0) {
            $coupon = Coupon::get_a_coupon($request)->content * 100;
            if (count($data) > 1) 
                return $coupon."% still has ". count($data) ." books;";
            else 
                return $coupon."% still has ". count($data) ." book;";
        }
        else {
            Coupon::remove($request);
        }
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET status = 0 WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_coupon SET status = 1 WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_coupon WHERE coupon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

}
