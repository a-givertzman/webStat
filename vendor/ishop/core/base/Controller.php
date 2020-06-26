<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace ishop\base;

/**
 * Класс Controller | Базовый класс контроллера приложения, содержит общиее
 *                    свойства и методы, необходимые для всех контроллеров.
 *                    От данного класса наследуется AppController
 */
abstract class Controller {

    
    
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
    public function __construct($route) {
        
        $this->route        = $route;
        $this->controller   = $route['controller'];
        $this->model        = $route['controller'];
        $this->view         = $route['action'];
        $this->prefix       = $route['prefix'];
        $this->data         = [];
        $this->meta         = ['title' => '', 'desc' => '', 'keywords' => ''];
    }

    
    
    /**
     * Метод | Получает View
     *         Вызывается маршрутизатором
     */
    public function getView() {

        // создаем объект вида
        $view = new View($this->route, $this->layout, $this->view, $this->meta);
        
        // формируем страничку
        $view->render($this->data);
    }


    
    /**
     * Метод | Получает и сохраняет массив данных для рендеринга view
     */
    public function set($data) {
        
        $this->data = $data;
    }
    
    
    
    /**
     * Метод | Получает и сохраняет метаданные
     */
    public function setMeta($title = '', $desc = '', $keywords = '') {
        
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}
