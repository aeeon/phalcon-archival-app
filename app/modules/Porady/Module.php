<?php

namespace Porady;

class Module
{

    public function registerAutoloaders()
    {

    }

    public function registerServices($di)
    {
        $dispatcher = $di->get('dispatcher');
        $dispatcher->setDefaultNamespace('Porady\Controller');
        $di->set('dispatcher', $dispatcher);

        /**
         * Setting up the view component
         */
        $view = $di->get('view');
        $view->setViewsDir(__DIR__ . '/views/');

    }

}