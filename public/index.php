<?php

/**
 * v.001
 * 
 * В данном файле происходит старт web-приложения
 * И загрузка всех необходимых файлов
 *
 * @author antonlobanov
 */

// Подключаем настроечный файл
require_once dirname(__DIR__) .'/config/init.php';

// подключаем автозагрузку классов (composer)
require_once ROOT ."/vendor/autoload.php";

// подключаем обработчик ошибок
$errHandler = new ishop\ErrorHandler();


// подключаем общие функции
require_once LIBS .'/Ganeral.php';

// Подключаем правила маршрутов
require_once CONFIG .'/routes.php';


//debug('debuger');

//debug('Это главная страница');

//echo print_r($_SERVER['QUERY_STRING'], 1);
//debug($app_path);


$iShop = new ishop\App();

$iShop::$app->setProperty('newProp', 'prop');

//debug($iShop::$app->getProperties());
//print_r(ishop\App::$app->getProperties());


//throw new Exception('Упс, такой странички нет', 404);
//throw new Exception('Упс, такой странички нет', 500);

//debug(\ishop\Router::getRoutes());