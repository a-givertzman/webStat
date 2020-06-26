<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace ishop\base;

use ishop\Db;



/**
 * Класс Model | Отвечает за работу с данными
 *               В том числе:
 *                 - валидация данных
 *                 - работа с файлами
 *                 - работа с базой данных
 */
abstract class Model {
    
    
    
    public $attributes = [];        // для обмена с базой данных
    public $errors = [];            // массив ошибок
    public $rules = [];             // правила валидации данных
    
    
    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct() {
        
        // создаем объект работы с БД
        Db::instance();
    }
}
