<?php
/**
 * @copyright Copyright (c) 2011 - 2014 Oleksandr Torosh (http://wezoom.net)
 * @author Oleksandr Torosh <web@wezoom.net>
 */

namespace Publication\Controller;

use Application\Mvc\Controller;
use Publication\Form\TypeForm;
use Publication\Model\Type;

class TypeController extends Controller
{

    public function initialize()
    {
        $this->setAdminEnvironment();
    }

    public function indexAction()
    {
        $this->view->entries = Type::find();

        $this->helper->title('Typy publikacji', true);
    }

    public function addAction()
    {
        $this->view->pick(array('type/edit'));

        $form = new TypeForm();
        $model = new Type();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);

            if ($form->isValid()) {
                if ($model->create()) {
                    $form->bind($post, $model);
                    $model->updateFields($post);
                    if ($model->update()) {
                        $this->flash->success('Zaktualizowano');
                        return $this->redirect($this->url->get() . 'publication/type/edit/' . $model->getId() . '?lang=' . LANG);
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

        $this->view->model = $model;
        $this->view->form = $form;
        $this->helper->title($this->helper->at('Dodawanie typu publikacji'));
    }

    public function editAction($id)
    {
        $form = new TypeForm();
        $model = Type::findFirst($id);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);

            if ($form->isValid()) {
                $model->updateFields($post);
                if ($model->update()) {
                    $this->flash->success('Zaktualizowano');
                    return $this->redirect($this->url->get() . 'publication/type/edit/' . $model->getId() . '?lang=' . LANG);
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
        $this->helper->title($this->helper->at('Edycja typu publikacji'));
    }

    public function deleteAction($id)
    {
        $model = Type::findFirst($id);
        $count = Type::count();
        if ($count == 1) {
            $this->flash->error($this->helper->at('Nie mogę usunąć typu publikacji'));
            return;
        }

        if ($this->request->isPost()) {
            $model->delete();
            $this->redirect($this->url->get() . 'publication/type');
        }

        $this->view->model = $model;
        $this->helper->title($this->helper->at('Usuń typ'));
    }

} 