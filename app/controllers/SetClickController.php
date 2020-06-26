<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace app\controllers;

// use Error
use \ishop\App;
use \app\models\ProductModel;
use \app\models\BreadcrumbsModel;


/**
 * Класс SetClickController | 
 */
class SetClickController extends AppController {
    

    /**
     * Метод | Экшн по умолчанию
     */
    public function indexAction() {

        // получаем алиас запрошенного продукта
        // $alias = $this->route['alias'];
        
        \ishop\libs\Debuger::clear();
        debug("SetClickController");
        debug($_GET);
    
        $data['domain'] = !empty($_GET['domain']) ? $_GET['domain'] : 'uncnown domain';
        $data['path'] = !empty($_GET['path']) ? ($_GET['path']) : 'null';
        $data['posx'] = !empty($_GET['posx']) ? $_GET['posx'] : 'null';
        $data['posy'] = !empty($_GET['posy']) ? $_GET['posy'] : 'null';
        $data['timestamp'] = !empty($_GET['timestamp']) ? $_GET['timestamp'] : 'null';

        $path = [];
        $path[] = $data['domain'];
        $path[] = $data['path'];

        $this->setClick($path);
        // debug($id);

        $jsonData = json_encode(array(
            "data" => $data ?: "No Data",
            "stat" => "ok"
        ));
        // debug("jsonData:");
        // debug($jsonData);

        header('Access-Control-Allow-Origin: *');
        // header('Content-Type: application/xml');
        
        echo $jsonData;                                                // передаем данные

        // debug($data);
        die;
        // берем всю информацию по запрошенному продукту из БД
        // $product = \RB::findOne('product', "`alias` =? and `status` = '1' and `deleted` is null", [$alias]);
        
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


    protected function setClick($path = []) {
        $id = 0;
        foreach($path as $value) {
            $pathSegment = \RB::getRow("select * from `path` where `url` = '" . $value . "';");
            if (empty($pathSegment)) {
                $query = "insert `path` set `url`='" . $value . "', `parent_id`=" . $id;
                debug($query);
                \RB::exec($query);
                $id = \RB::getInsertID();
            } else {
                $id = $pathSegment['id'];
            }
        }
    }
}