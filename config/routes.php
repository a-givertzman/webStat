<?php

/**
 * v.001
 * 
 * В данном файле объявляются правила маршрутов
 * Более общие правила должны быть ниже более конкретных
 *
 * @author antonlobanov
 */

use ishop\Router;



// ПОЛЬЗОВАТЕЛЬСКИХ ПРАВИЛ [ НАЧАЛО ]
// Тут можно объявить более конкретные пользовательсткие правила


// Правило для запростов типа...
//    Router::add(
//        'regexp',                                           // RegExp для поиска url в маршрутах
//        ['controller' => 'Main', 'action' => 'index']       // маршрут, соответствующий данному url
//    );

    // для странички продукта
    Router::add(
        '^product/(?P<alias>[a-z0-9-]+)$',                // RegExp для url типа product/product-name
        ['controller' => 'Product', 'action' => 'view']   // маршрут, соответствующий данному url
    );






// ПОЛЬЗОВАТЕЛЬСКИХ ПРАВИЛ [ КОНЕЦ ]



// Общие маршруты по умолчанию

    // Для запросов админки
    Router::add(
        '^admin$', 
        ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']
    );
    
    Router::add(
        '^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', 
        ['prefix' => 'admin']
    );

    
    
    // для пользовательских запросов
    Router::add(
        '^$',                                           // RegExp для поиска url в маршрутах
        ['controller' => 'Main', 'action' => 'index']   // маршрут, соответствующий данному url
    );
    
    Router::add(
        '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$'
    );