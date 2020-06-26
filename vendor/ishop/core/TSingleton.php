<?php

/*
 * v.001
 * 
 * @author antonlobanov
 */

namespace ishop;



/**
 * Trait for Singleton
 */
trait TSingleton {
    
    
    
    // храним здесь ссылку на себя
    private static $instance;
    
    
    
    public static function instance() {
//        debug(__CLASS__ ." Singleton initialised.<br>");
        
        // если ссылка на себя пуста,
        // то создаем екземпляр себя
        // и храним его в $instance
        if(self::$instance === null) {
            self::$instance = new self;
        }
        
        // возвращаем ссылку на себя
        return self::$instance;
    }
}
