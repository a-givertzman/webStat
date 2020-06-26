<?php

/**
 * v.001
 * 
 * В данном файле объявляются глобальные константы
 * И настройки web-приложения
 *
 * @author antonlobanov
 */



define("DEBUG", 1);                                 // 0 - все ошибки скрыты, 1 - все ошибки выводятся
define("DEBUG_TO_FILE", 1);                         // 0 - логирование в поток, 1 - логирование в файл
define("ROOT", dirname(__DIR__));
define("WWW", ROOT .'/public');
define('IMPORT', ROOT .'/public/import');           // сторонние импортируемые элементы
define("APP", ROOT .'/app');
define("CORE", ROOT .'/vendor/ishop/core');
define("LIBS", ROOT .'/vendor/ishop/core/libs');
define("CACHE", ROOT .'/tmp/cache');
define("LOGS", ROOT .'/tmp/logs');
define("CONFIG", ROOT .'/config');
//define("LAYOUT", 'default');                        // шаблон страницы по умолчанию
define("LAYOUT", 'watches');                        // шаблон страницы по умолчанию

$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$app_path = preg_replace("#[^/]+$#", "", $app_path);
$app_path = str_replace("/public/", "", $app_path);

define("PATH", $app_path);
define("ADMIN", PATH ."/admin");