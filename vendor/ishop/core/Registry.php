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
class Registry {
    
    
    
    // копируем сюда из Trait TSingleton
    use TSingleton;
    
    
    
    // массив для хранения свойств
    protected static $properties = [];
    
    
    
    /**
     * Метод setter | Добавляет свойство в массив
     */
    public function setProperty($name, $value) {
        self::$properties[$name] = $value;
//        debug("Registry.setProperty: name: $name,  val: $value<br>");
    }
    
    
    
    /**
     * Метод getter | Возвращает свойство с именем $name 
     *                либо null, если такого свойства нет
     */
    public function getProperty($name) {
        if(isset(self::$properties[$name])) {
            return self::$properties[$name];
        }
        return null;
    }
    
    
    /**
     * Метод для отладки | Возвращает весь массив свойств
     */
    public function getProperties() {
        return self::$properties;
    }
}
