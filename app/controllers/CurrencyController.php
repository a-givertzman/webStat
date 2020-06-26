<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\controllers;

use ishop\App;
use app\controllers\AppController;



/**
 * Класс CurrencyController | Управляет выбором активной валюты
 */
class CurrencyController extends AppController {
    
    
    public function changeAction() {
        
        // выбранная валюта
        $currencyCode = !empty($_GET['currency']) ? $_GET['currency'] : false;
        
        if ($currencyCode) {
            
            // получаем массив доступных валют из кэша
            $cache = \ishop\Cache::instance();
            $currencies = App::$app->getProperty('currencies');
            
            if (key_exists($currencyCode, $currencies)) {
                // если выбранная пользователем валюта есть в списке домтупных
                // то сохраняем ее как текущую в куке
                setcookie('currency', $currencyCode, time() + 3600*24*7, '/');
            }
        }
        // переходим на страничку с которой пришли
        redirect();
    }
}