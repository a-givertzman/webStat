<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\controllers;

use \ishop\App;
use \app\models\ProductModel;
use \app\models\BreadcrumbsModel;


/**
 * Класс MainController | 
 */
class ProductController extends AppController {
    

    /**
     * Метод | Экшон по умолчанию
     */
    public function viewAction() {

        // получаем алиас запрошенного продукта
        $alias = $this->route['alias'];
        
        // берем всю информацию по запрошенному продукту из БД
        $product = \RB::findOne('product', "`alias` =? and `status` = '1' and `deleted` is null", [$alias]);
        
        if (empty($product)) {
            // если запрошенный продукт не найден в БД
            // то выбрасывем ошибку 404
            throw new \Exception("Не найдена страница продукта: $alias", 404);
        }
        
        // массив категорий
        $category = App::$app->getProperty('category');

        // запись в куки запрошенного товара
        $productModel = new ProductModel();
        $productModel->setRecentlyViewed($product['id']);
        
        // хлебные крошки
        $breadcrumbsModel = new BreadcrumbsModel();
        $breadcrumbs = $breadcrumbsModel->getBreadcrumbs($product['category_id'], $product['title']);

        // связанные товары
        $related = \RB::getAll("
            select * from `related_product`
            join `product`
            on `product`.`id` = `related_product`.`related_id`
            where `related_product`.`product_id` = ?;
            ", [$product['id']]
        );
        
        // ранее просмотренные товары
        $recentlyViewed = $productModel->getRecentlyViewed($product['id'], 3);

        // галерея
        $gallery = \RB::getAll("
            select * from `gallery`
            where `gallery`.`product_id` = ?
            ", [$product['id']]
        );

        // модификации запрошенного товара (цвета, комплектации и т.д)
        $mods = \RB::getAll("
            select * from `modification`
            where `product_id` = ?
            ", [$product['id']]
        );

        // передаем странице метаданные
        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        
        // передаем массив данных для рендеринга view
        $this->set(compact('product', 'category', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'mods'));
    }
}
