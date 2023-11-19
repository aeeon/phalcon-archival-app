<?php

namespace Comment\Controller;

use Application\Mvc\Controller;
use Comment\Model\Comment;
use Comment\Form\CommentForm;

class AdminController extends Controller {

    public function initialize() {
        $this->setAdminEnvironment();
        $this->view->languages_disabled = true;

        $this->helper->activeMenu()->setActive('admin-comment');
    }

    public function indexAction() {
        $this->view->entries = Comment::find(["order" => "created_at DESC"]);

        $this->helper->title($this->helper->at('Komentarze'), true);
    }

    public function addAction() {
        $this->view->pick(['admin/edit']);
        $form = new CommentForm();
        $model = new Comment();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                if ($model->create()) {
                    $form->bind($post, $model);
                    $model->updateFields($post);
                    if ($model->update()) {
                        $this->flash->success($this->helper->at('Komentarz został dodany'));
                        return $this->redirect($this->url->get() . 'comment/admin/edit/' . $model->getId() . '?lang=' . LANG);
                    } else {
                        $this->flashErrors($model);
                    }
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        }

        $this->helper->title($this->helper->at('Komentarze'), true);

        $this->view->model = $model;
        $this->view->form = $form;
    }

    public function editAction($id) {
        $id = (int) $id;
        $form = new CommentForm();
        $model = Comment::findFirst($id);


        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->updateFields($post);
                $status = $this->request->getPost('status');
                ($status != null) ? $model->setStatus(1) : $model->setStatus(0);
                if ($model->save()) {
                    $this->flash->success($this->helper->at('Komentarz został zaktualizowany'));

                    // Очищаем кеш страницы
                    $query = "id = '{$model->getId()}'";
                    $key = md5("Comment::findFirst($query)");
                    $this->cache->delete($key);

                    return $this->redirect($this->url->get() . 'comment/admin/edit/' . $model->getId() . '?lang=' . LANG);
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        } else {
            $form->setEntity($model);
        }

        $this->view->model = $model;
        $this->view->form = $form;
        $this->helper->title($this->helper->at('Edytuj komentarz'), true);
    }

    public function deleteAction($id) {
        $model = Comment::findFirst($id);


        if ($this->request->isPost()) {
            $model->delete();
            $this->redirect($this->url->get() . 'comment/admin');
        }

        $this->view->model = $model;
        $this->helper->title($this->helper->at('Usuń komentarz'), true);
    }

    public function deleteselectedAction() {

        if ($this->request->isPost()) {
            $action = $this->request->getPost("action");
            $items = $this->request->getPost("items");
            if ($action == 'confirm') {
                $this->view->items = $items;
                $this->helper->title($this->helper->at('Usunąć wszystkie?'), true);
            } else {
                // usun wszystkie
                foreach ($items as $item) {
                    Comment::findFirst($item)->delete();
                }
                $this->redirect($this->url->get() . 'comment/admin');
            }
        }
    }

}
