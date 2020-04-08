<?php
require_once 'Zend/Loader/Autoloader.php';

error_reporting(E_ALL | E_STRICT);

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/../application'));

// Definición del directorio de imagenes de la aplicación
defined('IMAGES_PATH') || define('IMAGES_PATH', realpath(__DIR__ . '/../public/images'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('ENV_APPLICATION') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(realpath(PATH_APPLICATION . '/../library'), get_include_path())));

Zend_Loader_Autoloader::getInstance();
Zend_Session::$_unitTestEnabled = true;
Zend_Session::start();

$application = new Zend_Application(APPLICATION_ENV, PATH_APPLICATION . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'application.ini');
$application->bootstrap();

$layout = Zend_Layout::getMvcInstance();
if ($layout->isEnabled()) {
    $layout->disableLayout();
}
$layout->resetMvcInstance();

$application->run();
