<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\controllers;



/**
 * Класс MainController | 
 */
class MainController extends AppController {
    

    /**
     * Метод | Экшон по умолчанию
     */
    public function indexAction() {

        // получаем данные из таблицы brand
        $brands = \RB::find('brand', 'order by rand() limit 3');
        
        // получаем хиты из таблицы products
        $hits = \RB::find('product', "(`deleted` is null) and `hit` = '1' and `status` = '1' order by rand() limit 8");
        
        // передаем странице метаданные
        $this->setMeta(
            'Web - статистика',                             // title
            'Статистика кликов по всем подключенным сайтам',// description
            ''                                              // keywords
        );
        
        // передаем массив данных для рендеринга view
        $this->set(compact('brands', 'hits'));
    }
}