<?php
class User
{
    var $user_id;
    var $name;
    var $username;
    var $password;
    var $authority;
    var $address;
    var $number;
    var $status;
    var $ward_id;
    var $district_id;
    var $province_id;

    public function __construct($user_id, $name, $username, $password, $authority, $address, $number, $status, $ward_id, $district_id, $province_id)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->authority = $authority;
        $this->address = $address;
        $this->number = $number;
        $this->status = $status;
        $this->ward_id = $ward_id;
        $this->district_id = $district_id;
        $this->province_id = $province_id;
    }
    public static function get_all_data()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 1") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function get_data_according_to_search_name($search_name)
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE status = 1 AND (username like '%$search_name%' OR username Like '$search_name%' OR username like '%$search_name')");
        $stmt->execute([$search_name]);
        $books = $stmt->fetchAll();
        foreach ($books as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function sort_none($user_list, $start_record, $record_limit)
    {
        $data = [];
        foreach ($user_list as $user) {
            if ($user->user_id != null) {
                $data[$user->user_id] =  $user->name;
            }
        }
        $array_key = array_keys($data);
        $total = count($array_key);
        $users = [];
        $count = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= $start_record) {
                array_push($users, user::get_an_user($array_key[$i]));
                $count++;
            }
            if ($count == $record_limit)
                break;
        }
        return $users;
    }
    
    public static function do_remove($request) {
        $data = Order::get_all_undone_orders_each_customer($request);
        if (count($data) > 0) {
            if (count($data) > 1) 
                return User::get_an_user($request)->name." still has ". count($data) ." undone orders left;";
            else 
                return User::get_an_user($request)->name." still has ". count($data) ." undone order left;";
        }
        else {
            User::remove($request);
        }
    }

    public static function remove($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET status = 0 WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function restore($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET status = 1 WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function delete($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "DELETE FROM tbl_user WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request]);
    }

    public static function get_data_for_restore()
    {
        $data = [];
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        foreach ($pdo->query("SELECT * from tbl_user WHERE status = 0") as $row) {
            array_push($data, new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]));
        }
        return $data;
    }

    public static function grant_right_for_user($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET authority = ? WHERE user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["authority"], $request["user_id"]]);
    }


    public static function get_an_user($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_id = ?");
        $stmt->execute([$request]);
        $row = $stmt->fetch();
        $data = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
        return $data;
    }
    public static function find_account($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND status = 1");
        $stmt->execute([$request]);
        $user = $stmt->fetchAll();
        if ($user != null)
            return true;
        else
            return false;
    }
    public static function check_password($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ? AND status = 1");
        $stmt->execute([$request["username"], $request["password"]]);
        $user = $stmt->fetch();
        if ($user != null)
            return true;
        else
            return false;
    }
    public static function do_login($request)
    {
        if (User::find_account($request["username"])) {
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE authority = 0 AND username = ? AND password = ? AND status = 1");
            $stmt->execute([$request["username"], $request["password"]]);
            $user = $stmt->fetch();
            if (User::check_password($request)) {
                $row = $user;
                if ($user != null) {
                    $_SESSION["user"]["id"] = $row["user_id"];
                    $_SESSION["user"]["username"] = $row["username"];
                    $_SESSION["user"]["name"] = $row["name"];
                    $_SESSION["user"]["authority"] = $row["authority"];
                } else {
                    return "This account doesn't exist!";
                }
            } else {
                return "Wrong password!";
            }
        } else {
            return "This account doesn't exist!";
        }
    }
    public static function admin_do_login($request)
    {
        if (User::find_account($request["username"])) {
            $config = include CONFIG . "config.php";
            $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
            $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ? AND authority = 1 AND status = 1");
            $stmt->execute([$request["username"], $request["password"]]);
            $user = $stmt->fetch();
            if (User::check_password($request)) {
                $row = $user;
                if ($user != null) {
                    $_SESSION["admin"]["id"] = $row["user_id"];
                    $_SESSION["admin"]["username"] = $row["username"];
                    $_SESSION["admin"]["name"] = $row["name"];
                    $_SESSION["admin"]["authority"] = $row["authority"];
                } else {
                    return "This account doesn't exist!";
                }
            } else {
                return "Wrong password!";
            }
        } else {
            return "This account doesn't exist!";
        }
    }
    public static function do_logout()
    {
        session_unset();
        session_destroy();
    }
    public static function insert($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "INSERT INTO tbl_user (name,username,password,authority,address,number,status,ward_id,district_id,province_id) VALUES (?,?,?,0,?,?,1,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["username"], $request["password"], $request["address"], $request["number"], $request["ward_id"], $request["district_id"], $request["province_id"]]);
    }

    public static function do_register($request)
    {
        if (User::find_account($request["username"])) {
            return "This username has already been used!";
        } else {
            if ($request["password"] != $request["re_password"]) {
                return "The two password don't match";
            } else {
                User::insert($request);
                return "";
            }
        }
    }

    public static function update($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        $sql = "UPDATE tbl_user SET name = ?, address = ? , number = ? ,ward_id = ? , district_id = ? , province_id = ? WHERE user_id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$request["name"], $request["address"], $request["number"], $request["ward_id"], $request["district_id"], $request["province_id"], $request["user_id"]]);
    }

    public static function change_password($request)
    {
        $config = include CONFIG . "config.php";
        $pdo = new PDO($config["dsn"] . ":host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["dbname"], $config["username"], $config["password"]);
        if (User::check_password($request)) {
            $sql = "UPDATE tbl_user SET password = ? WHERE user_id = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$request["new_password"], $request["user_id"]]);
        } else {
            return "Old password isn't correct!";
        }
    }
}
