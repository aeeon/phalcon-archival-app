<?php

/**
 * Routes
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Publication;

use Publication\Model\Publication;
use Publication\Model\Type;

class Routes {

    public function init($router) {
        $types_keys = array_keys(Type::types());
        $types2 = "(artykuly)";

       // unset($types_keys[3]); // usuwamy wpis "encyklopedia"!

        $types_regex = '(' . implode('|', $types_keys) . ')';

        $router->add('/publication/admin/{type:' . $types_regex . '}', array(
            'module' => 'publication',
            'controller' => 'admin',
            'action' => 'index'
        ))->setName('publications_admin');

        $router->add('/publication/admin/{type:' . $types_regex . '}/([a-zA-Z0-9_]+)', array(
            'module' => 'publication',
            'controller' => 'admin',
            'action' => 2
        ))->setName('publications_admin_action');

        $router->add('/publication/{psearch:(szukaj)}/:params', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'search',
            'params' => 2
        ))->setName('publication_szukaj');

        $router->add('/publication/{psearch:(wyszukaj)}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'wyszukaj'
        ))->setName('publication_wyszukaj');

        $router->add('/publication/{psearch:(szukajdoc)}/:params', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'searchdoc',
            'params' => 2
        ))->setName('dokumenty_szukaj');

        $router->add('/publication/{psearch:(wyszukajdoc)}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'wyszukajdoc'
        ))->setName('dokumenty_wyszukaj');

      /*  $router->addML('/{type:' . $types2 . '}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'index'
                ), 'publications');*/

        $router->addML('/{type:' . $types2 . '}/{category:[a-zA-Z0-9_-]+}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'index'
                ), 'publications');
        $router->addML('/{type:' . $types2. '}/{category:[a-zA-Z0-9_-]+}/{subcategory:[a-zA-Z0-9_-]+}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'index'
                ), 'publications');
        $router->addML('/{type:' . $types2. '}/{category:[a-zA-Z0-9_-]+}/{subcategory:[a-zA-Z0-9_-]+}/{subsubcategory:[a-zA-Z0-9_-]+}', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'index'
                ), 'publications');  
        
        $router->addML('/{type:' . $types2 . '}/{slug:[a-zA-Z0-9_-]+}.html', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'publication'
                ), 'publication');
        
       $router->addML('/encyklopedia/:params', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'encyklopedia',
            'params' => 1
                ), 'encyklopedia');
       $router->addML('/encyklopedia', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'encyklopedia'
                ), 'encyklopedia');
        $router->addML('/encyklopedia/{slug:[a-zA-Z0-9_-]+}.html', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'encyklopediaItem'
                ), 'encyklopedia_item');   
                
             $router->addML('/dokumenty/{slug:[a-zA-Z0-9_-]+}.html', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'wzory'
                ), 'dokumenty_item');   
                   
        $router->addML('/wzory.html', array(
            'module' => 'publication',
            'controller' => 'index',
            'action' => 'wzory',
                ), 'wzory');
        return $router;
    }

}
