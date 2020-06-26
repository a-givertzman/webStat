<?php

/*
 * v.001
 * 
 * @author antonlobanov
 */

namespace ishop;



/**
 * Класс App | Баловый класс web-приложения - iShop Application
 */
class App {
    
    
    
    // контейнер для хранения свойств приложения
    public static $app;
    

    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct() {
//        debug(get_class($this) ."." .__FUNCTION__ ."<br>");

        // подключаем обработчик ошибок
        // подключили в public/index.php
        // new ErrorHandler();
        
        // получаем запрошенны пользователем url
        $query = trim($_SERVER['QUERY_STRING'], '/');
        
        // стартуем новую сессию
        session_start();
        
        // создаем объект (singleton Registry) для хранения свойств приложения
        self::$app = Registry::instance();
                
        // считываем свойства приложения из файла
        $this->getParams();
        
        // передаем маршрутизатору запрошенный url
        Router::dispatch($query);
    }
    
    
    
    /**
     * Метод | Считывает параметры приложения из файла CONFIG ."/params.php"
     */
    protected function getParams() {
        $params = require_once CONFIG ."/params.php";
        
        if(!empty($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}
