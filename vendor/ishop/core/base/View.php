<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace ishop\base;



/**
 * Класс View | Базовый класс вида
 */
class View {

    
    public $route;
    public $controller;
    public $model;
    public $layout;
    public $view;
    public $prefix;
    public $data = [];      // данные для рендеринга view
    public $meta = [];


    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct($route, $layout = '', $view = '', $meta) {
        
        $this->route        = $route;
        $this->controller   = $route['controller'];
        $this->model        = $route['controller'];
        $this->view         = $view;
        $this->prefix       = $route['prefix'];
//        $this->data         = [];
        $this->meta         = $meta;
        
        // если шаблон страницы определен как false - без шаблона
        if ($layout === false) {
            
            // то сохраняем это в свойство вида 
            $this->layout = false;
            
        } else {
            
            // если шаблон не определен, то берем шабон по умолчанию
            // если определен, то сохраняем в свойство вида
            $this->layout = $layout ?: LAYOUT;
        }
    }
    
    
    
    /**
     * Метод | Формирует страничку для пользователя
     *         Отдает результат контроллеру
     */
    public function render($data) {
        
        // распаковываем массив data в переменные
        if (is_array($data)) extract ($data);
        
        // имя файла запрошенного view
        $viewFile = APP ."/views/{$this->prefix}{$this->controller}/{$this->view}.php";
        
        if (is_file($viewFile)) {
            // если запрошенный view существует, загружаем и сохраняем его
            
            // вкелючаем буферизацию
            ob_start();
            
            // отправляем страницу в буфер
            require $viewFile;
            
            // сохраняем буферизованный контент,
            // что бы позднее использовать его в шаблоне
            $content = ob_get_clean();
            
        } else {
            // если файл запрошенного вида не найден
            // то выбрасывем ошибку 500
            throw new \Exception("Не найден вид: $viewFile", 500);
        }
        
        
        // подключаем шаблон, если нужен
        if ($this->layout !== false) {
            
            // имя файла шаблона
            $layoutFile = APP ."/views/layouts/{$this->layout}.php";
            
            if (is_file($layoutFile)) {
                // если такой шаблон существует,
                //  то подключаем его
                require_once $layoutFile;
                
            } else {
                // если файл запрошенного шаблона не найден
                // то выбрасывем ошибку 500
                throw new \Exception("Не найден шаблон: $layoutFile", 500);
            }
        } else {
            // если шаблон не нужен
        }
        
//        debug(__METHOD__ ." | data:");
//        debug($data);
    }

    
    
    /**
     * Метод | Формирует метаданные
     */
    public function getMeta() {
        $result = "<title>" . $this->meta['title'] . "</title>" .PHP_EOL;
        $result .= '<meta name="description" content="' . $this->meta['desc'] . '">' .PHP_EOL;
        $result .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' .PHP_EOL;
        return $result;
    }
}
