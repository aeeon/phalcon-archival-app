<?php

/**
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.net)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

/* TODO:
 *  sprawdzić warunki, że gdy język ustawiony jako nieaktywny, czy to przypadkiem nie jest domyślny język
 */
namespace Cms\Controller;

use Application\Mvc\Controller;
use Cms\Form\LanguageForm;
use Cms\Model\Language;

class LanguageController extends Controller {

    public function initialize() {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('admin-language');
        $this->view->languages_disabled = true;
    }

    public function indexAction() {
        $this->view->entries = Language::find(array(
                    'order' => 'primary DESC, sortorder ASC',
        ));

        $this->view->title = $this->helper->at('Zarządzaj językami');
        $this->helper->title($this->view->title);
    }

    public function addAction() {
        $this->view->pick(array('language/edit'));
        $form = new LanguageForm();
        $model = new Language();

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $model);
            if ($form->isValid()) {
                if ($model->save()) {
                    $this->cache->delete(Language::cacheKey());
                    $this->flash->success($this->helper->at('Aktualizacja wykonana pomyślnie'));
                    return $this->redirect($this->url->get() . 'cms/language');
                } else {
                    $this->flashErrors($model);
                }
            } else {
                $this->flashErrors($form);
            }
        }

        $this->view->model = $model;
        $this->view->form = $form;

        $this->view->title = $this->helper->at('Dodawanie języka');
        $this->helper->title($this->view->title);
    }

    public function editAction($id) {
        $form = new LanguageForm();
        $model = Language::findFirst($id);

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $model);
            if ($form->isValid()) {

                $is_primary = $this->request->getPost('primary');
                $is_active = $this->request->getPost('active');
                ($is_primary != null) ? $model->setPrimary(1) : $model->setPrimary(0);
                ($is_active != null) ? $model->setActive(1) : $model->setActive(0); 
                if ($model->save()) {
                    $model->setOnlyOnePrimary();
                    $this->flash->success($this->helper->at('Aktualizacja wykonana pomyślnie'));
                    $this->cache->delete(Language::cacheKey());
                    return $this->redirect($this->url->get() . 'cms/language/edit/' . $model->getId());
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

        $this->view->title = 'Edycja języka';
        $this->helper->title($this->view->title);
    }

    public function deleteAction($id) {
        $model = Language::findFirst($id);

        if ($this->request->isPost()) {
            $this->cache->delete(Language::cacheKey());
            $model->delete();
            return $this->redirect($this->url->get() . 'cms/language');
        }

        $this->view->model = $model;
        $this->view->title = $this->helper->at('Usuwanie języka');
        $this->helper->title($this->view->title);
    }

}
