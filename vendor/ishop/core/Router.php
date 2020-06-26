<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace ishop;



/**
 * Класс Router | Хранит массив маршрутов, считанный из toutes.php
 *                Ищет запрошенный url в массиве маршрутов, в случае
 *                совпадения запускает соответствующий controller и action
 *
 */
class Router {
    
    
    protected static $routes = [];                      // массив маршрутов
    protected static $route = [];                       // текущий маршрут
    
    
    
    // Метод | Добавляет маршруты в массив маршрутов
    public static function add($regexp, $route = []) {
        
        self::$routes[$regexp] = $route;
    }
    
    
    
    // Метод для отладки | Возвращает массив маршрутов
    public static function getRoutes() {
        
        return self::$routes;
    }
    
    
    
    // Метод для отладки | Отправляет клиенту запрошенную страницу
    public static function getRoute() {
        
        return self::$route;
    }
    
    
    
    /**
     * Метод | Отправляет клиенту запрошенную страницу
     *         Запускает контроллер, соответствующий запрошенному url
     */
    public static function dispatch($url) {
        
        // удаляем GET-запрос из url
        $url = self::removeQueryString($url); 
        // debug($url);

        // проверяем запрошенный url на соответствие маршруту
        if (self::matchRoute($url)) {
            
            // если маршрут для запрошенного url найден
            
            // получаем имя класса контроллера из текущего маршрута
            $controllerName = 'app\controllers\\' . self::$route['prefix'] .self::$route['controller'] .'Controller';
            
            if (class_exists($controllerName)) {
                // если класс контроллера существует
                
                // создаем объект класса контроллера
                $controller = new $controllerName(self::$route);

                // получаем имя метода из текущего маршрута
                $action = self::$route['action'] . 'Action';
                
                // проверяем наличие метода action в объекте контроллера
                if (method_exists($controller, $action)) {
                    
                    // вызываем метод action
                    $controller->$action();
                    
                    // получаем view
                    $controller->getView();
                    
                } else {
                    // если метод action в контроллере не найден
                    // то выбрасывем ошибку 404
                    throw new \Exception("Не найден метод контроллера: $controllerName::$action", 404);
                }

            } else {
                // если класс контроллера не найден
                // то выбрасывем ошибку 404
                throw new \Exception("Не найден контроллер: $controllerName", 404);
            }
            
            
        } else {
            
            // если маршрут для запрошенного url не найден
            // то выбрасывем ошибку 404
            throw new \Exception('Страница не найдена', 404);
        }
    }



    /**
     * Метод | Ищет запрошенный url в таблице маршрутов
     */
    public static function matchRoute($url) {
        
        // для поиска запрошенного url среди допустимых маршрутов
        // перебираем массив маршрутов и проверим каждый на совпадение с url
        foreach (self::$routes as $pattern => $route) {
            
            // проверяем url на совпадение с текущим машрутом
            if (preg_match("#{$pattern}#", $url, $matches)) {
                
                // найденный маршрут копируем в route
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                
                // если в запрошенном url нет action, то в route добавляем значение по умолчанию
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                
                
                // если в запрошенном url нет prefix, то в route добавляем значение по умолчанию
                // в конец prefix добавляем \ (обратный слэш)
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                
                // приводим наименование controller к формату psr-4
                $route['controller'] = self::upperCamelCase($route['controller']);
                
                // приводим наименование controller к формату psr-4
                $route['action'] = self::lowerCamelCase($route['action']);

                // сохраняем текущий маршрут
                self::$route = $route;
                
                return true;
            }
        }
        return false;
    }
    
    
    
    /**
     * Метод | Приводит имя к формату CamelCase
     */
    protected static function upperCamelCase($name) {
        
        // заменяем "-" на " "
        // new-page => new page
        $name = str_replace('-', ' ', $name);
        
        // Делаем первую букву каждого слова заглавной
        // new page => New Page
        $name = ucwords($name);
        
        // заменяем " " на ""
        // New Page => NewPage
        $name = str_replace(' ', '', $name);
        
        return $name;
    }



    /**
     * Метод | Приводит имя к формату camelCase
     */
    protected static function lowerCamelCase($name) {
        
        // получаем CamelCase
        $name = self::upperCamelCase($name);
        
        // делаем первую букву малой camelCase
        $name = lcfirst($name);
        
        return $name;
    }

    
    
    /**
     * Метод | Удалает GET-параметры из url
     */
    protected static function removeQueryString($url) {
        
        if (!empty($url)) {
            // Если url не пуст
            // то разбираем url на два элемента, разделитель - &
            $params = explode("&", $url, 2);
            
            if (strpos($params[0], '=') === false) {
                // если в нулевом элементе нет символа '=' то возвращаем это как путь url без последнего слэша
                return rtrim($params[0], '/');
                
            } else {
                // если в нулевом лементе сивол '=', то путь пуст, запрошена главная страничка
                return '';
            }
        }
    }
}
