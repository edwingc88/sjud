<?php

// Activar cuando deseemos una versión específica de ZF
// define('LIB_ZENDFRAMEWORK_VERSION', '1.12.10');

// Definición del directorio del proyecto
defined('PATH_PROJECT') || define('PATH_PROJECT', __DIR__);

// Definición y validación de las bibliotecas compartidas
$envLibShared = getenv('ENV_LIB_SHARED') ? getenv('ENV_LIB_SHARED') : __DIR__ . '/../zendlib';
defined('ENV_LIB_SHARED') 
    || (define('ENV_LIB_SHARED', realpath($envLibShared)) && ENV_LIB_SHARED) 
    || exit("No existe el directorio de bibliotecas compartidas ENV_LIB_SHARED=$envLibShared en " . __FILE__ . ' (' . __LINE__ . ').');

require ENV_LIB_SHARED . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';