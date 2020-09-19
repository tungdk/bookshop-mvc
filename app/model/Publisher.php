<?php
class Publisher
{
    var $publisher_id;
    var $name;
    var $address;
    var $email;
    var $number;
    var $status;

    public function __construct($publisher_id, $name, $address,$email,$number,$status)
    {
        $this->publisher_id = $publisher_id;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->number = $number;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher WHERE status = 1") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_publisher WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Publisher($row[0], $row[1], $row[2], $row[3],$row[4],$row[5]));
        }
        return $data;
    }


    public static function sort_none($publisher_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($publisher_list as $publisher) {
            if ($publisher->publisher_id != null) {
                $data[$publisher->publisher_id] =  $publisher->name;
            }
        }
        $array_key = array_keys($data);
        $total = count($array_key);
        $publishers = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($publishers, Publisher::get_publisher_for_filter($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $publishers;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_publisher WHERE status = 0") as $row) {
            array_push($data, new publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]));
        }
        return $data;
    }

    public static function get_publisher_for_filter($publisher_id) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_publisher WHERE publisher_id=?");
        $stmt->execute([$publisher_id]);
        $row = $stmt->fetch();
        $publisher = new Publisher($row[0], $row[1], $row[2],$row[3],$row[4],$row[5]);
        return $publisher;
    } 

    public static function insert($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_publisher (name,address,email,number,status) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"],$request["address"],$request["email"], $request["number"],1]);
    }

    public static function update($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET name = ? , address = ? , email = ? , number = ? , status = ?  WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["address"],$request["email"],$request["number"],$request["status"],$request["publisher_id"]]);
    }

    public static function do_remove($request) {
        $data = Book::get_data_according_to_publisher($request);
        if (count($data) > 0) {
            if (count($data) > 1) 
                return Publisher::get_publisher_for_filter($request)->name." still has ". count($data) ." relating books;";
            else 
                return Publisher::get_publisher_for_filter($request)->name." still has ". count($data) ." relating book;";
        }
        else {
            Publisher::remove($request);
        }
    }
    public static function remove($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET status = 0 WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_publisher SET status = 1 WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request) {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_publisher WHERE publisher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

}
