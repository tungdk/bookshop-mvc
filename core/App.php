<?php 
class App {
    protected $directory = "Bookshop";
    protected $controller = "HomeController";
    protected $action = "index";
    protected $params = [];
#
    function __construct()
    {
        $this->preprocess();
        if (file_exists(CONTROLLER.$this->controller.".php")) {
            $ctl = new $this->controller;
            if (method_exists($ctl, $this->action)) {
                call_user_func_array([$ctl, $this->action],$this->params);
            }
        }
    }

    public function preprocess()
    {
        $request = trim($_SERVER["REQUEST_URI"],"/");
        if (!empty($request)) {
            $url = explode("/",$request);
            $temp = ucfirst(strtolower(array_shift($url)));
            $this->directory = $temp;
            $this->controller = isset($url[0]) ? $url[0] . "Controller" : "HomeController";
            $this->action = isset($url[1]) ? strtolower(($url[1])) : "index";
            $this->params = $url;
        }
    }

}
