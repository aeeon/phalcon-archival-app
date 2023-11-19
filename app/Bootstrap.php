<?php

namespace YonaCMS;

use Phalcon\Logger;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;
use Phalcon\Cache\Backend\Redis as RedisBackend;

/**
 * Bootstrap
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */
class Bootstrap {

    public function run() {
        $di = new \Phalcon\DI\FactoryDefault();

        // Config
        require_once APPLICATION_PATH . '/modules/Cms/Config.php';
        $config = \Cms\Config::get();
        $di->set('config', $config);

        // Registry
        $registry = new \Phalcon\Registry();
        $di->set('registry', $registry);

        // Loader
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces($config->loader->namespaces->toArray());
        $loader->registerDirs([APPLICATION_PATH . "/plugins/"]);
        $loader->register();
        require_once APPLICATION_PATH . '/../vendor/autoload.php';

        $di->set('db', function () use ($config, $registry) {

            $eventsManager = new EventsManager();

            $logger = new FileLogger(APPLICATION_PATH . "/logs/debug.log");

            if (false) {
                // Listen all the database events
                $eventsManager->attach('db', function ($event, $connection) use ($logger) {
                    if ($event->getType() == 'beforeQuery') {
                        $sqlVariables = $connection->getSQLVariables();
                        if (count($sqlVariables)) {
                            $logger->log($connection->getSQLStatement() . ' ' . join(', ', $sqlVariables), Logger::INFO);
                        } else {
                            $logger->log($connection->getSQLStatement(), Logger::INFO);
                        }
                    }
                });
            }

            $connection = new Connection(
                    array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->dbname,
                "charset" => $config->database->charset,
                    )
            );

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        });

        // View
        $this->initView($di);

        // URL
        $url = new \Phalcon\Mvc\Url();
        $url->setBasePath($config->base_path);
        $url->setBaseUri($config->base_path);
        $di->set('url', $url);

        // Cache
        $this->initCache($di);

        // CMS
        $cmsModel = new \Cms\Model\Configuration();
        $registry->cms = $cmsModel->getConfig(); // Отправляем в Registry
        // Application
        $application = new \Phalcon\Mvc\Application();
        $application->registerModules($config->modules->toArray());

        // Events Manager, Dispatcher
        $this->initEventManager($di);

        // Session
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        $di->set('session', $session);

        $acl = new \Application\Acl\DefaultAcl();
        $di->set('acl', $acl);

        // JS Assets
        $this->initAssetsManager($di);

        // Flash helper
        $flash = new \Phalcon\Flash\Session([
            'error' => 'ui red inverted segment',
            'success' => 'ui green inverted segment',
            'notice' => 'ui blue inverted segment',
            'warning' => 'ui orange inverted segment',
        ]);
        $di->set('flash', $flash);

        $di->set('helper', new \Application\Mvc\Helper());

        $di->set('mailer', function () use ($config) {
            $mail = new \PHPMailer;
            $mail->IsSendmail(); 
            //$mail->isSMTP();
            $mail->isHTML(true);
            $mail->CharSet = $config->mail->charset;
            //$mail->Host = $config->mail->host;
            //$mail->SMTPAuth = true;
          //  $mail->SMTPSecure = $config->mail->security;
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only

            $mail->Username = $config->mail->username;
            $mail->Password = $config->mail->password;
            //$mail->SMTPSecure = $config->mail->security;
            //$mail->Port = $config->mail->port;

             $mail->addAddress($config->mail->email, $config->mail->name);

            return $mail;
        });
        /*                              'minsize' => 1024, // bytes,
           'mimes' => [// any allowed mime types
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                    'text/plain',
                    'application/pdf'
                ],
                'extensions' => [// any allowed extensions
                    'gif',
                    'jpeg',
                    'jpg',
                    'png',
                    'txt', 'doc', 'pdf', 'docx', 'rdf', 'odt', 'xls', 'pot'
                ],*/
        $di->set('uploader', function () {
            $uploader = new \Uploader\Uploader;
            
            // setting up uloader rules
            $uploader->setRules([
                'directory' => APPLICATION_PATH . '/files',
                //or 'dynamic'   =>  '/files/'.$part.'/'.$userId, // added v1.4-beta

                'maxsize' => 1024 * 1024 * 5, // 5mb
                'sanitize' => true,
                'hash' => 'md5'
            ]);
            return $uploader;
        });

        // Routing
        $this->initRouting($application, $di);

        $application->setDI($di);

        // Main dispatching process
        $this->dispatch($di);
    }

    private function initRouting($application, $di) {
        $router = new \Application\Mvc\Router\DefaultRouter();
        $router->setDi($di);
        foreach ($application->getModules() as $module) {
            $routesClassName = str_replace('Module', 'Routes', $module['className']);
            if (class_exists($routesClassName)) {
                $routesClass = new $routesClassName();
                $router = $routesClass->init($router);
            }
            $initClassName = str_replace('Module', 'Init', $module['className']);
            if (class_exists($initClassName)) {
                new $initClassName();
            }
        }
        $di->set('router', $router);
    }

    private function initAssetsManager($di) {
        $config = $di->get('config');
        $assetsManager = new \Application\Assets\Manager();
        $js_collection = $assetsManager->collection('js')
                ->setLocal(true)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin())
                ->setTargetPath(ROOT . '/assets/js.js')
                ->setTargetUri('assets/js.js')
                ->join(true);
        if ($config->assets->js) {
            foreach ($config->assets->js as $js) {
                $js_collection->addJs(ROOT . '/' . $js);
            }
        }

        // Admin JS Assets
        $assetsManager->collection('modules-admin-js')
                ->setLocal(true)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin())
                ->setTargetPath(ROOT . '/assets/modules-admin.js')
                ->setTargetUri('assets/modules-admin.js')
                ->join(true);

        // Admin LESS Assets
        $assetsManager->collection('modules-admin-less')
                ->setLocal(true)
                ->addFilter(new \Application\Assets\Filter\Less())
                ->setTargetPath(ROOT . '/assets/modules-admin.less')
                ->setTargetUri('assets/modules-admin.less')
                ->join(true)
                ->addCss(APPLICATION_PATH . '/modules/Admin/assets/admin.less');

        $di->set('assets', $assetsManager);
    }

    private function initEventManager($di) {
        $eventsManager = new \Phalcon\Events\Manager();
        $dispatcher = new \Phalcon\Mvc\Dispatcher();

        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) use ($di) {
            new \YonaCMS\Plugin\CheckPoint($di->get('request'));
            new \YonaCMS\Plugin\Localization($dispatcher);
            new \YonaCMS\Plugin\AdminLocalization($di->get('config'));
            new \YonaCMS\Plugin\Acl($di->get('acl'), $dispatcher, $di->get('view'));
           // new \YonaCMS\Plugin\MobileDetect($di->get('session'), $di->get('view'), $di->get('request'));
        });

        $eventsManager->attach("dispatch:afterDispatchLoop", function ($event, $dispatcher) use ($di) {
            new \Seo\Plugin\SeoManager($dispatcher, $di->get('request'), $di->get('router'), $di->get('view'));
            new \YonaCMS\Plugin\Title($di);
        });

        // Profiler
        $registry = $di->get('registry');
        if ($registry->cms['PROFILER']) {
            $profiler = new \Phalcon\Db\Profiler();
            $di->set('profiler', $profiler);

            $eventsManager->attach('db', function ($event, $db) use ($profiler) {
                if ($event->getType() == 'beforeQuery') {
                    $profiler->startProfile($db->getSQLStatement());
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            });
        }

        $db = $di->get('db');
        $db->setEventsManager($eventsManager);

        $dispatcher->setEventsManager($eventsManager);
        $di->set('dispatcher', $dispatcher);
    }

    private function initView($di) {
        $view = new \Phalcon\Mvc\View();

        define('MAIN_VIEW_PATH', '../../../views/');
        $view->setMainView(MAIN_VIEW_PATH . 'main');
        $view->setLayoutsDir(MAIN_VIEW_PATH . '/layouts/');
        $view->setLayout('main');
        $view->setPartialsDir(MAIN_VIEW_PATH . '/partials/');

        // Volt
        $volt = new \Application\Mvc\View\Engine\Volt($view, $di);
        $volt->setOptions(['compiledPath' => APPLICATION_PATH . '/../data/cache/volt/']);
        $volt->initCompiler();


        $phtml = new \Phalcon\Mvc\View\Engine\Php($view, $di);
        $viewEngines = [
            ".volt" => $volt,
            ".phtml" => $phtml,
        ];

        $view->registerEngines($viewEngines);

        $ajax = $di->get('request')->getQuery('_ajax');
        if ($ajax) {
            $view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
        }

        $di->set('view', $view);

        return $view;
    }

    private function initCache($di) {
        $config = $di->get('config');

        $cacheFrontend = new \Phalcon\Cache\Frontend\Data([
            "lifetime" => 60,
            "prefix" => HOST_HASH,
        ]);

        $cache = null;
        switch ($config->cache) {
            case 'redis':
                //Create the Cache setting redis connection options
                $cache = new \Phalcon\Cache\Backend\Redis($cacheFrontend, array(
                    'host' => $config->redis->host,
                    'port' => $config->redis->port,
                    'persistent' => false
                ));
                break;            
            case 'file':
                $cache = new \Phalcon\Cache\Backend\File($cacheFrontend, [
                    "cacheDir" => APPLICATION_PATH . "/../data/cache/backend/"
                ]);
                break;
            case 'memcache':
                $cache = new \Phalcon\Cache\Backend\Memcache(
                        $cacheFrontend, [
                    "host" => $config->memcache->host,
                    "port" => $config->memcache->port,
                ]);
                break;
        }
        $di->set('cache', $cache, true);
        $di->set('modelsCache', $cache, true);

        \Application\Widget\Proxy::$cache = $cache; // Modules Widget System

        $modelsMetadata = new \Phalcon\Mvc\Model\Metadata\Memory();
        $di->set('modelsMetadata', $modelsMetadata);
    }

    private function dispatch($di) {
        $router = $di['router'];

        $router->handle();

        $view = $di['view'];

        $dispatcher = $di['dispatcher'];

        $response = $di['response'];

        $dispatcher->setModuleName($router->getModuleName());
        $dispatcher->setControllerName($router->getControllerName());
        $dispatcher->setActionName($router->getActionName());
        $dispatcher->setParams($router->getParams());

        $moduleName = \Application\Utils\ModuleName::camelize($router->getModuleName());

        $ModuleClassName = $moduleName . '\Module';
        if (class_exists($ModuleClassName)) {
            $module = new $ModuleClassName;
            $module->registerAutoloaders();
            $module->registerServices($di);
        }

        $view->start();

        $registry = $di['registry'];
        if ($registry->cms['DEBUG_MODE']) {
            $debug = new \Phalcon\Debug();
            $debug->listen();

            $dispatcher->dispatch();
        } else {
            try {
                $dispatcher->dispatch();
            } catch (\Phalcon\Exception $e) {
                // Errors catching

                $view->setViewsDir(__DIR__ . '/modules/Index/views/');
                $view->setPartialsDir('');
                $view->e = $e;

                if ($e instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                    $response->setHeader(404, 'Not Found');
                    $view->partial('error/error404');
                } else {
                    $response->setHeader(503, 'Service Unavailable');
                    $view->partial('error/error503');
                }
                $response->sendHeaders();
                echo $response->getContent();
                return;
            }
        }

        $view->render(
                $dispatcher->getControllerName(), $dispatcher->getActionName(), $dispatcher->getParams()
        );

        $view->finish();

        $response = $di['response'];

        // AJAX
        $request = $di['request'];
        $_ajax = $request->getQuery('_ajax');
        if ($_ajax) {
            $contents = $view->getContent();

            $return = new \stdClass();
            $return->html = $contents;
            $return->title = $di->get('helper')->title()->get();
            $return->success = true;

            if ($view->bodyClass) {
                $return->bodyClass = $view->bodyClass;
            }

            $headers = $response->getHeaders()->toArray();
            if (isset($headers[404]) || isset($headers[503])) {
                $return->success = false;
            }
            $response->setContentType('application/json', 'UTF-8');
            $response->setContent(json_encode($return));
        } else {
            $response->setContent($view->getContent());
        }

        $response->sendHeaders();

        echo $response->getContent();
    }

}
