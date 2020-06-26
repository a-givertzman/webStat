<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\controllers;

use ishop\App;
use ishop\Cache;
use ishop\base\Controller;
use app\models\AppModel;
use app\widgets\currency\Currency;



/**
 * Класс AppController | Контроллер приложения
 *                       Содержит общий код для контроллеров различных назначений
 */
class AppController extends Controller {
    
    
    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct($route) {
        parent::__construct($route);

        // подключаем модель для работы с данными
        new AppModel();
        
        // подключаем виджет выбора валют
        
        // массив доступных валют сохраняем в Registry приложения
        App::$app->setProperty('currencies', Currency::getCurrencies());
           
        // активную валюту тоже сохраняем в Registry приложения
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
        
        // категории сохраняем в Registry приложения
        // !!! в случае большого количества категорий
        // смотри сколько этот массив ест памяти, если много,
        // то можно просто получать каждый рах из кэш
        App::$app->setProperty('category', self::cacheCategory());
    }
    
    
    
    /**
     * Метод | Возвращает категории из кэш или БД
     *         Если кэш пуст или устарел, то обновляет категоирии в кэш
     */
    public static function cacheCategory() {

        // получаем объект кэша
        $cache = Cache::instance();
        
        // получаем категории из кэш
        $category = $cache->get('category');
        
        if (empty($category)) {
            
            // если в кэше пусто, то получаем категории из БД
            $category = \RB::getassoc("select * from category");
            
            // и сохраняем их в кэш
            $cache->set('category', $category);
        }
        
        // возвращаем категории
        return $category;
    }
}
