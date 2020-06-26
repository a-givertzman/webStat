<?php

/* 
 * Глобальные функции общего назначения
 */



// инициализация дебагера
// можно инициализировать синглтон дебагера и задать ему настройки
//$debuger = ishop\libs\Debuger::instance();
// или можно создать алиас для дебагера
function debug($data) {
    if (DEBUG_TO_FILE == 1) {
        ishop\libs\Debuger::flog($data);
    } else {
        ishop\libs\Debuger::log($data);
    }
}



function redirect ($url = false) {
    if ($url) {
        // если url не пуст, то переходим на url
        $target = $url;
    } else {
        // если url пуст, то переходим на страничку с которой пришел
        // и если referer пуст, то переходим на главную страничку
        $target = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
//    debug($target);
    header("Location: $target");
    exit();
}