<?php

namespace Index\Controller;

use Application\Mvc\Controller;
use Page\Model\Page;
use Publication\Model\Publication;
use Phalcon\Exception;
use Publication\Model\Type;
use Tree\Model\Category;

class IndexController extends Controller {

    public function indexAction() {
        $query = "SELECT * FROM Publication\Model\Publication AS p
WHERE  p.date <= NOW()
    AND p.status = 'publish'
            AND p.type_id ='2'";
        $query .= " ORDER BY p.date DESC";

        $publications = $this->modelsManager->executeQuery($query);

        $typeLimit = 8;
        $limit = $this->request->getQuery('limit', 'string', $typeLimit);
        if ($limit != 'all') {
            $paginatorLimit = (int) $limit;
        } else {
            $paginatorLimit = 9999;
        }
        $page = $this->request->getQuery('page', 'int', 1);

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $publications,
            "limit" => $paginatorLimit,
            "page" => $page
        ));

        $this->view->paginate = $paginator->getPaginate();

       // $this->helper->title()->append($typeModel->getHead_title());
        if ($page > 1) {
            $this->helper->title()->append($this->helper->translate('Strona nr.') . ' ' . $page);
        }
        
        $this->view->title = $title;
        $this->view->format = 'grid';
        $cat='';
        $this->view->cat = $cat;

       // $this->helper->menu->setActive($type);
    }
    public function indexAction2()
    {
        $this->view->bodyClass = 'home';

        $page = Page::findCachedBySlug('index');
        if (!$page) {
            throw new Exception("Strona 'index' nie została znaleziona");
        }
        $this->helper->title()->append($page->getMeta_title());
        $this->helper->meta()->set('description', $page->getMeta_description());
        $this->helper->meta()->set('keywords', $page->getMeta_keywords());
        $this->view->page = $page;

        $this->helper->menu->setActive('index');

    }

}
