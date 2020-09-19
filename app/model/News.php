<?php
class News
{
    var $news_id;
    var $name;
    var $content;
    var $image;
    var $date;
    var $status;

    public function __construct($news_id, $name, $content, $image, $date, $status)
    {
        $this->news_id = $news_id;
        $this->name = $name;
        $this->content = $content;
        $this->image = $image;
        $this->date = $date;
        $this->status = $status;
    }

    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_news Where status = 1") as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 1 AND (name like '%$search_name%' OR name Like '$search_name%' OR name like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function sort_date($news_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($news_list as $news) {
            if ($news->news_id != null) {
                $data[$news->news_id] =  $news->date;
            }
        }
        arsort($data);
        $array_key = array_keys($data);
        $total = count($array_key);
        $newss = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($newss, News::get_a_news($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $newss;
    }

    public static function get_a_news($request)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id = ? ");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $news =  new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        return $news;
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 0");
        $stmt->execute();
        $news = $stmt->fetchAll();
        foreach ($news as $row) {
            array_push($data, new News($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]));
        }
        return $data;
    }

    public static function insert($request) {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_news (name,content,image,date,status) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["content"], $request["image"], $date, 1]);
    }

    public static function update($request)
    {
        $date = date("y-m-d");
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET name = ? , content = ? , date = ? , image = ?  WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["content"], $date, $request["image"], $request["news_id"]]);
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET status = 0 WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    
    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_news SET status = 1 WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

        
    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_news WHERE news_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }
}
