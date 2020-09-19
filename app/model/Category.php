<?php
class Category
{
    var $category_id;
    var $name;
    var $description;
    var $status;

    public function __construct($category_id, $name, $description, $status)
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 1") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }
    public static function sort_none($category_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($category_list as $category) {
            if ($category->category_id != null) {
                $data[$category->category_id] =  $category->name;
            }
        }
        $array_key = array_keys($data);
        $total = count($array_key);
        $categories = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($categories, Category::get_category_for_filter($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $categories;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_category WHERE status = 0") as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_category WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new Category($row[0], $row[1], $row[2], $row[3]));
        }
        return $data;
    }


    public static function get_category_for_filter($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $category = new Category($row[0], $row[1], $row[2], $row[3]);
        return $category;
    }

    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_category (name,description,status) VALUES (?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], 1]);
    }

    public static function update($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET name = ? , description = ?   WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["description"], $request["category_id"]]);
    }

    public static function do_remove($request) {
        $data = Book::get_data_according_to_category($request);
        if (count($data) > 0) {
            if (count($data) > 1) 
                return "Category ".Category::get_category_for_filter($request)->name." still has ". count($data) ." relating books;";
            else 
                return "Category ".Category::get_category_for_filter($request)->name." still has ". count($data) ." relating book;";
        }
        else {
            Category::remove($request);
        }
    }
    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET status = 0 WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_category SET status = 1 WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_category WHERE category_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
