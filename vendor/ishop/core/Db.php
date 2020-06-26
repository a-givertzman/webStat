<?php

/*
 * v.001
 * 
 * @author antonlobanov
 */

namespace ishop;



/**
 * Класс Registry | Синглтон для хранения свойств приложения
 * 
 * Based on pattern Singleton
 * Created on Trait TSingleton
 */
class Db {

    
    
    // копируем сюда из Trait TSingleton
    use TSingleton;

    
    
    /**
     * Метод | Создание экземпляра класса
     */
    protected function __construct() {
        $dbConfig = require_once CONFIG .'/db_config.php';

        // псевдоним для класса \RedBeanPHP\R
        class_alias('\RedBeanPHP\R', 'RB');
        
        // подключаемся к БД
        \RB::setup($dbConfig['dsn'], $dbConfig['user'], $dbConfig['pass']);
        
        // проверяем подключение к БД
        if (\RB::testConnection()) {
//            echo 'Соединение установлено';
            
            // Снимаем режим заморозки
            \RB::freeze(true);
            
            // настраиваем режим отладки библиотеки RedBean
            if (DEBUG) {
                \RB::debug(true, 1);    //select mode 1 to suppress screen output
            }
            
        } else {
            // если не удалось подключиться к БД
            // то выбрасывем ошибку 500
            throw new \Exception("Нет соединения с БД", 500);            
        }
    }
    
}
