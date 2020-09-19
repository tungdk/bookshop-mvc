

<?php
define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("PUBLICS", ROOT . "public" . DIRECTORY_SEPARATOR);
define("APP", ROOT . "app" . DIRECTORY_SEPARATOR);
define("CONFIG", APP . "config" . DIRECTORY_SEPARATOR);
define("MODEL", APP . "model" . DIRECTORY_SEPARATOR);
define("VIEW", APP . "view" . DIRECTORY_SEPARATOR);
define("CONTROLLER", APP . "controller" . DIRECTORY_SEPARATOR);

define('CORE', ROOT . 'core' . DIRECTORY_SEPARATOR);



$module = [MODEL, VIEW, CONTROLLER, CORE];
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $module));
spl_autoload_register("spl_autoload", false);

new App;
?>