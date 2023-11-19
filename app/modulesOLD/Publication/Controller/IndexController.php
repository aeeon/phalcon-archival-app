<?php

namespace Publication\Controller;

use Application\Mvc\Controller;
use Publication\Model\Publication;
use Phalcon\Exception;
use Publication\Model\Type;
use Tree\Model\Category;
use Comment\Model\Comment;
use Comment\Form\CommentFrontendForm;

class IndexController extends Controller {

    public function wyszukajAction() {

        $search = $this->request->getPost('search', "string", "");
        if (empty($search) || strlen($search) < 3) {
            $search = "null";
        }
        $search = preg_replace("/[^[:alnum:][:space:][-_]]/u", '', $search);
        $this->response->redirect('publication/szukaj/' . $search);
    }

    public function searchAction() {
       // print_r($this->dispatcher->getParams(1));exit;
        $search = current($this->dispatcher->getParams());
        $psearch = $this->dispatcher->getParam('psearch', 'string');


        $query = "SELECT p.* FROM Publication\Model\Publication AS p";

        if (!empty($psearch)) {

            if ($search !== 'null') {
                $query .= " LEFT JOIN Publication\Model\Translate\PublicationTranslate t ON p.id = t.foreign_id AND (t.key='title' OR t.key='text')";

                $query .= " WHERE t.lang = '" . LANG . "'";
                $query .= " AND ((t.value LIKE CONCAT('%', '{$search}', '%') AND t.key = 'text') OR (t.value LIKE CONCAT('%', '{$search}', '%') AND t.key = 'title'))";
                $query .= " GROUP BY p.id";
                //die($query);

                $query .= " ORDER BY p.date DESC";

                $publications = $this->modelsManager->executeQuery($query);


                $limit = 10;
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
            } else {
                $search = null;
            }
            $this->helper->title()->append("Wyniki wyszukiwania");
            if ($page > 1) {
                $this->helper->title()->append($this->helper->translate('Strona nr.') . ' ' . $page);
            }
        }
        $this->view->title = "Wyniki wyszukiwania";
        $this->view->search = $search;
    }

    public function indexAction() {
        $type = $this->dispatcher->getParam('type', 'string');
        $category = $this->dispatcher->getParam('category', 'string');
        $subcategory = $this->dispatcher->getParam('subcategory', 'string');

        $typeModel = Type::getCachedBySlug($type);
        $catModel = Category::getCachedBySlug($category);
        $scatModel = Category::getCachedBySlug($subcategory);


        $cond_array = [];
        $typeLimit = 10;

        if (!$typeModel) {
            throw new Exception("Publication hasn't type = '$type''");
        } else {
            $type_id = $typeModel->getId();
            $cond_array[] = "type_id = $type_id";
            $title = $typeModel->getTitle();
            $typeLimit = ($typeModel->getLimit()) ? $typeModel->getLimit() : 10;
        }

        if ($scatModel) {
            $cat_id = $scatModel->getId();
            $cond_array[] = "category_id = $cat_id";
            $title = $scatModel->getTitle();
            //  $this->view->subcat = $title;
        } else if ($catModel) {
            $cat_id = $catModel->getId();
            $cond_array[] = "category_id = $cat_id";
            $title = $catModel->getTitle();
            //$this->view->maincat = $category;
        } else {
            
        }
        $cat = $cat_id;

        // echo $type_id . " " . $cat;
        //           LEFT JOIN publication_type t
        //   ON t.id = p.type_id
        $query = "SELECT p.* FROM Publication\Model\Publication AS p";



        $query .= " WHERE p.type_id='{$type_id}' 
    AND p.date <= NOW()
    AND p.status = 'publish'";

        if (!empty($cat)) {
            $query .= " AND p.category_id IN
    (
    SELECT c.id FROM Tree\Model\Category AS c
    WHERE c.id='{$cat}' or c.parent_id ='{$cat}'"
                    . ")";
        }

        $query .= " ORDER BY p.date DESC";

        $publications = $this->modelsManager->executeQuery($query);


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

        $this->helper->title()->append($typeModel->getHeadTitle());
        if ($page > 1) {
            $this->helper->title()->append($this->helper->translate('Strona nr.') . ' ' . $page);
        }

        $this->view->title = $title;
        $this->view->format = $typeModel->getFormat();

        $this->view->type = $type;
        $this->view->type_id = $type_id;
        $this->view->cat = $cat;

        $this->helper->menu->setActive($type);
    }

    public function publicationAction() {
        $comment_form = new CommentFrontendForm();
        $slug = $this->dispatcher->getParam('slug', 'string');
        $type = $this->dispatcher->getParam('type', 'string');
        $typeModel = Type::getCachedBySlug($type);
        $type_id = $typeModel->getId();
        $commentModel = new Comment();

        $publication = Publication::findCachedBySlug($slug);

        if (!$publication) {
            throw new Exception("Publikacja '$slug.html' nie została znaleziona");
            //return $this->redirect($this->url->get());
        }
        if ($publication->getTypeSlug() != $type) {
            throw new Exception("Publication type <> $type");
        }
        $publication->naliczWejscie();
        $comments = $commentModel::find("foreign_key = '{$publication->getId()}'");
        $this->helper->title()->append($publication->getMetaTitle());
        $this->helper->meta()->set('description', $publication->getMetaDescription());
        $this->helper->meta()->set('keywords', $publication->getMetaKeywords());

        $this->view->publication = $publication;
        $this->view->comment_form = $comment_form;
        $this->view->comments = $comments;
        $this->view->cat = $publication->getCategory_id();
        $this->view->current_id = $publication->getId();
        $this->view->type_id = $type_id;
        $this->helper->menu->setActive($type);
    }

    public function wzoryAction() {

        $type = 'dokumenty';
        $typeModel = Type::getCachedBySlug($type);
        $page = $this->request->getQuery('page', 'int', 1);


        $tree = [];

        $id = 0;

        $subentries = \Tree\Model\Category::find(array(
                    "conditions" => "depth = '1' AND root = '{$type}'",
                    "order" => "left_key",
        ));

        if (!empty($subentries)) {


            foreach ($subentries as $subentry) {

                $subchilds = \Tree\Model\Category::find(array(
                            "conditions" => "depth = '2' AND root = '{$type}' AND parent_id = '{$subentry->getId()}'",
                            "order" => "left_key",
                ));

                //  $item = \Tree\Model\Category::findFirst("id='{$subentry->getId()}'");
                $childs = array();
                foreach ($subchilds as $child) {

                    $childs[] = $child->getTitle();
                }

                $tree[] = array("entry" => $subentry->getTitle(), "childs" => $childs);
            }
        } else {
            $tree = array();
        }


        //$this->view->paginate = $paginator->getPaginate();

        $this->helper->title()->append($typeModel->getHeadTitle());
        if ($page > 1) {
            $this->helper->title()->append($this->helper->translate('Strona nr.') . ' ' . $page);
        }

        $this->helper->meta()->set('description', $typeModel->getMetaDescription());
        $this->helper->meta()->set('keywords', $typeModel->getMetaKeywords());

        $this->view->title = $typeModel->getTitle();
        $this->view->format = $typeModel->getFormat();

        $this->view->tree = $tree;

        $this->helper->menu->setActive($type);
    }

}
