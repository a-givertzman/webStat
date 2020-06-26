<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\widgets\menu;

use ishop\App;
use \ishop\Cache;


/**
 * Класс | Виджет меню сайтй, построенного
 * Menu  | на дереве категорий из БД или кэш
 */
class Menu {

    
    protected $data;                    // массив категорий
    protected $tree;                    // дерево категорий, многомерный массив
    protected $html;                    // html-код всего меню
    protected $tpl;                     // шаблон категории меню
    protected $container = 'ul';        // контейнер меню (html-тэг)
    protected $class = 'main_menu';     // 
    protected $table = 'category';      // таблица БД, где хранится меню
    protected $cacheTime = 3600;        // время хранения кэш
    protected $cacheKey = 'main_menu';  // ключ под которым хранится кэш
    protected $attrs = [];              // массив дополнительных атрибутов
    protected $prepend = '';            // сообщение пользователю (главное меню/выбери значение)
    
    
    
    /**
     * Метод | Создание экземпляра класса
     */
    public function __construct($options = []) {
        
        // путь к шаблону меню по умолчанию
        $this->tpl = __DIR__ .'/tpl/menu.php';
        
        // получаем настройки переданные пользователеем и сохраняем их во внутренние переменные класса
        $this->setOptions($options);
        
        // запускаем виджет
        $this->run();
    }
    
    
    
    /**
     * Метод | Сохраняет значения свойств из массива $options, переданного
     *         пользователем в соответствующие свойства класса
     */
    public function setOptions($options) {
        
        // перебираем массив свойств, полученный от пользователя
        foreach ($options as $key => $value) {
            
            if (property_exists($this, $key)) {
                // если свойство с таким именем в классе существует
                // то даем ему значение, определенное пользователем
                $this->$key = $value;
            }
        }
    }

    
 
    /**
     * Метод | Запуск виджета
     *         Рендерит меню
     */
    protected function run() {
        
        // получаем объект кэша
        $cache = Cache::instance();

        // получаем меню из кэша
        $this->html = $cache->get($this->cacheKey);
        
        if (empty($this->html)) {
            // если меню в кэше нет
            // то формируем меню
            
            // для этого получаем массив категорий из реестра если их не много
            $this->data = App::$app->getProperty('category');
            
            if (empty($this->data)) {
                // если в реестре категорий нет, то берем из кэш или БД
//                $this->data = \RB::getassoc("select * from category");      // можно взять категории из БД
                $this->data = \app\controllers\AppController::cacheCategory();            // или использовать существующий в AppController метод получения категорий из кэш/БД
            }
            $this->tree = $this->getTree();
            $this->html = $this->getMenuHtml($this->tree);
            
            if ($this->cacheTime > 0) {
                // если кэширование включено
                // то сохраняем свормированное меню в кэш
                $cache->set($this->cacheKey, $this->html, $this->cacheTime);
            }
        }
        // выводим меню
        $this->output();
    }
    
    
    
    /**
     * Метод | Отдает html версию меню клиенту
     */
    protected function output() {
        
        // сформируем строку атрибутов, если переданы
        $attrs = '';
        foreach ($this->attrs as $key => $value) {
            $attrs .= " {$key}='{$value}'";
        }
        
        echo "<{$this->container} class='{$this->class}' {$attrs}>";
        echo $this->html;
        echo "</{$this->container}>";
    }
    
    
    
    /**
     * Метод | Возвращает многомерный массив дерева категорий
     */
    protected function getTree() {
        $tree = [];
        $data = $this->data;
        
        foreach ($data as $id => &$node) {
            if (empty($node['parent_id'])) {
                $tree[$id] = &$node;
            } else {
                $data[ $node['parent_id'] ]['chield'][$id] = &$node;
            }
        }
        return $tree;
    }
    
    
    
    /**
     * Метод | Метод вернет меню в html формате для части дерева категорий $treeSegment
     *         $spacer - отступ категории в разметке (слева от категории будет добавлено
     *         количество отступов равное уровню вложенности категории)
     */
    protected function getMenuHtml($treeSegment, $spacer = '') {
        $html = '';
        foreach ($treeSegment as $id => $category) {
            $html .= $this->categoryToTpl($category, $spacer, $id);
        }
        return $html;
    }
    
    
    
    /**
     * Метод | Строит html-код категории меню на основе шаблона
     */
    protected function categoryToTpl($category, $spacer = '', $id) {
        // вкелючаем буферизацию
        ob_start();
            
        // загружаем шаблон из файла
        require $this->tpl;
        
        // возвращаем буферизованный контент,
        return ob_get_clean();
    }
    
}
