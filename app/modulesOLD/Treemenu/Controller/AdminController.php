<?php

namespace Treemenu\Controller;

use Application\Localization\Transliterator;
use Application\Mvc\Controller;
use Treemenu\Form\CategoryForm;
use Treemenu\Model\Category as TCategory;

class AdminController extends Controller {

    public function initialize() {
        $this->helper->activeMenu()->setActive('treemenu');
    }

    public function indexAction() {
        $this->setAdminEnvironment();
        $this->view->roots = TCategory::$roots;

        $assets = $this->getDI()->get('assets');
        $assets->collection('modules-admin-less')->addCss(__DIR__ . '/../assets/tree.less');
        $assets->collection('modules-admin-js')->addJs(__DIR__ . '/../assets/tree.js');

        $this->helper->title($this->helper->at('Drzewo menu'), true);
    }

    public function addAction() {
        if (!$this->request->getPost() || !$this->request->isAjax()) {
            return $this->flash->error('post ajax required');
        }

        $root = $this->request->getPost('root');
        $title = $this->request->getPost('title', 'string');

        $model = new TCategory();
        $model->setRoot($root);
        if ($model->create()) {
            $model->setTitle($title);
            if ($model->update()) {
                $this->returnJSON([
                    'success' => true,
                    'id' => $model->getId(),
                    'title' => $title,
                ]);
            } else {
                $this->returnJSON(['error' => implode(' | ', $model->getMessages())]);
            }
        } else {
            $this->returnJSON(['error' => implode(' | ', $model->getMessages())]);
        }
    }

    public function editAction($id) {
        $this->setAdminEnvironment();

        $form = new CategoryForm();
        $model = TCategory::findFirst($id);

        if (!$model) {
            $this->redirect($this->url->get() . 'treemenu/admin?lang=' . LANG);
        }

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->updateFields($post);
                if ($model->save()) {
                    $this->flash->success($this->helper->at('Aktualizacja zakończona sukcesem'));
                    $this->redirect($this->url->get() . 'treemenu/admin?lang=' . LANG);
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        } else {
            $form->setEntity($model);
        }

        $this->helper->title($this->helper->at('Edytuj kategorię'), true);

        $this->view->form = $form;
        $this->view->model = $model;
    }

    public function deleteAction() {
        if (!$this->request->getPost() || !$this->request->isAjax()) {
            return $this->flash->error('post ajax required');
        }

        $category_id = $this->request->getPost('category_id');

        $model = TCategory::findFirst($category_id);
        if ($model) {
            if ($model->delete()) {
                $this->returnJSON([
                    'success' => true,
                    'root' => $model->getRoot(),
                ]);
            }
        }
    }

    public function saveTreeAction() {
        if (!$this->request->getPost() || !$this->request->isAjax()) {
            return $this->flash->error('post ajax required');
        }

        $data = $this->request->getPost('data');

        foreach ($data as $el) {
            if ($el['item_id']) {
                $model = TCategory::findFirst($el['item_id']);
                if ($model) {
                    if ($el['parent_id']) {
                        $model->setParentId($el['parent_id']);
                    } else {
                        $model->setParentId(null);
                    }
                    $model->setDepth($el['depth']);
                    $model->setLeftKey($el['left']);
                    $model->setRightKey($el['right']);
                    $model->update();
                }
            }
        }

        $this->returnJSON(['success' => true]);
    }

}
