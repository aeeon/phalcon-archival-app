<?php

/**
 * AdminUserController
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Admin\Controller;

use Application\Mvc\Controller;
use Admin\Form\AdminUserForm;
use Admin\Model\AdminUser;

class AdminUserController extends Controller
{

    public function initialize()
    {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('admin-user');

        $this->view->languages_disabled = true;
    }

    public function indexAction()
    {
        $this->view->entries = AdminUser::find([
            "order" => "id DESC"
        ]);

        $this->helper->title($this->helper->at('Użytkownicy'), true);
    }

    public function addAction()
    {
        $this->view->pick(['admin-user/edit']);

        $model = new AdminUser();
        $form = new AdminUserForm();
        $form->initAdding();

        if ($this->request->isPost()) {
            $model = new AdminUser();
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {

                $model->setCheckboxes($post);
                if ($model->save()) {
                    $this->flash->success($this->helper->at('Użytkownik dodany', ['name' => $model->getLogin()]));
                    $this->redirect($this->url->get() . 'admin/admin-user');
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        }

        $this->view->form = $form;
        $this->view->model = $model;
        $this->view->submitButton = $this->helper->at('Dodaj');

        $this->helper->title($this->helper->at('Administrator'), true);
    }

    public function editAction($id)
    {
        $model = AdminUser::findFirst($id);
        if (!$model) {
            $this->redirect($this->url->get() . 'admin/admin-user');
        }

        $form = new AdminUserForm();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            if ($form->isValid()) {
                $model->setCheckboxes($post);
                if ($model->save() == true) {
                    $this->flash->success('Użytkownik <b>' . $model->getLogin() . '</b> został zaktualizowany');
                    return $this->redirect($this->url->get() . 'admin/admin-user');
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        } else {
            $form->setEntity($model);
        }

        $this->view->submitButton = $this->helper->at('Zapisz');
        $this->view->form = $form;
        $this->view->model = $model;

        $this->helper->title($this->helper->at('Użytkownicy'), true);
    }

    public function deleteAction($id)
    {
        $model = AdminUser::findFirst($id);
        if (!$model) {
            return $this->redirect($this->url->get() . 'admin/admin-user');
        }

        if ($model->getLogin() == 'admin') {
            $this->flash->error('Admin nie może zostać usunięty');
            return $this->redirect($this->url->get() . 'admin/admin-user');
        }

        if ($this->request->isPost()) {
            $model->delete();
            $this->flash->warning('Usuwanie użytkownika <b>' . $model->getLogin() . '</b>');
            return $this->redirect($this->url->get() . 'admin/admin-user');
        }

        $this->view->model = $model;

        $this->helper->title($this->helper->at('Delete User'), true);
    }

}
