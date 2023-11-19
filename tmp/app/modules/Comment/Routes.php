<?php

namespace Comment;

use Application\Mvc\Router\DefaultRouter;

class Routes
{

    public function init(DefaultRouter $router)
    {
        $router->add('/comment/add', array(
            'module' => 'comment',
            'controller' => 'index',
            'action' => 'add'
        ))->setName('comment_add');

        return $router;

    }

}