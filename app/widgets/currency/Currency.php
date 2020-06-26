<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\widgets\currency;

use ishop\App;


/**
 * Класс Currency | Класс-виджет выбора валют
 */
class Currency {
    
    
    protected $tpl;             // шаблон для выпадающего списка выбора валют
    protected $currencies;      // массив доступных валют
    protected $currency;        // текущая вылюта
    
    
    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct() {
        
        // путь к файлу, содержащему шаблон списка
        $this->tpl = __DIR__ .'/tpl/currency.php';
        
        // запускаем виджет
        $this->run();
    }
    
    
    
    /**
     * Метод | Запуск виджета
     *         Получает список валют,
     *         получает текущую валюту
     *         На основе этих данных запустит метод, который рендерит страничку
     */
    protected function run() {
        
        // получаем массив доступных валют из реестра приложения
        $this->currencies = App::$app->getProperty('currencies');
        
        // сохраняем массив доступных валюьт в кэш
        $cache = \ishop\Cache::instance();
        $cache->set('currencies', $this->currencies);
        
        // получаем текущую валюту из реестра приложения
        $this->currency = App::$app->getProperty('currency');
        
        // получаем шаблон выбора валют (выпадающий список в данном случае)
        // и отдаем шаблон клиенту
        echo $this->getHtml();
    }

    
    
    /**
     * Метод | Получает список всех валют
     */
    public static function getCurrencies() {
        
        return \RB::getAssoc(
            "select "
                . "`code`, `title`, `symbol_left`, `symbol_right`, `value`, `base` "
                . "from `currency` "
                . "order by `base` desc"
        );
    }

    
    
    /**
     * Метод | Получает текущую валюту
     *         Активную валюту получаем из cocies
     */
    public static function getCurrency($currencies) {
        
        // берем активную валюту из куки
        if (!empty($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)) {
            // если активная валюта существует,
            // и она есть в списке допустимых валют
            // то берем ключ активной валюты из массива валют
            $key = $_COOKIE['currency'];
        } else {
            // если валюта не выбрана или выбранной нет в списке
            // то берем ключ первой валюты в массиве, отсортированном по base
            $key = key($currencies);
        }
        
        // сохраняем активную валюту
        $currency = $currencies[$key];
        
        // добавляем в активную валюту ее код
        $currency['code'] = $key;
        
        return $currency;
    }



    /**
     * Метод | Формирует html разметку
     */
    protected function getHtml() {
        
        // вкелючаем буферизацию
        ob_start();
            
        // загружаем шаблон из файла
        require_once $this->tpl;
        
        // возвращаем буферизованный контент,
        return ob_get_clean();
    }
}
