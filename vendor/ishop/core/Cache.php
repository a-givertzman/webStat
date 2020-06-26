<?php

/*
 * v.001
 * 
 * @author antonlobanov
 */

namespace ishop;

/**
 * Класс Cache | Синглтон для хранения свойств приложения
 * 
 * Based on pattern Singleton
 * Created on Trait TSingleton
 */
class Cache {

    
    
    // копируем сюда из Trait TSingleton
    use TSingleton;

    
    
    /**
     * Метод | Сохраняет данные в кэш
     */
    public function set($key, $data, $seconds = 3600) {
        if ($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            
            if (file_put_contents(self::cacheFileName($key), serialize($content))) {
                // если удалось сохранить данные в файл, возвращаем true
                return true;
            }
        }
        
        // по умолчанию возвращаем false
        return false;
    }
    
    
    
    /**
     * Метод | Сохраняет данные в кэш
     */
    public function get($key) {
        $file = self::cacheFileName($key);
        
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                // возвращаем кэш, если он актуален
                return $content['data'];
            } else {
                // удалаем кэш, если он устарел
                unlink($file);
            }
        } else {
            return false;
        }
    }
    
    
    
    /**
     * Метод | Сохраняет данные в кэш
     */
    public function delete($key) {
        $file = self::cacheFileName($key);
        
        if (file_exists($file)) {
                // удалаем кэш
                unlink($file);
        }
    }
    
    
    
    /**
     * Метод | Возвращает имя кэш-файла
     */
    protected static function cacheFileName($key) {
        return CACHE .'/' . md5($key) .'.txt';
    }
}
