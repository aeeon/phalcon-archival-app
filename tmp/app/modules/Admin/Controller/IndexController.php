<?php

/**
 * AdminUserController
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Admin\Controller;

use Application\Mvc\Controller;
use Admin\Model\AdminUser;
use Admin\Form\LoginForm;
use Michelf\Markdown;
use Phalcon\Mvc\View;

class IndexController extends Controller
{

    public function indexAction()
    {
        $this->setAdminEnvironment();
        $this->view->languages_disabled = true;

        $auth = $this->session->get('auth');
        
        if (!$auth || !isset($auth->admin_session) || !$auth->admin_session) {
            $this->flash->notice($this->helper->at('Proszę się zalogować'));
            $this->redirect($this->url->get() . 'admin/index/login');
        }

        if ($this->registry->cms['DISPLAY_CHANGELOG']) {
           /* $changelog = file_get_contents(APPLICATION_PATH . '/../CHANGELOG.md');
            $changelog_html = Markdown::defaultTransform($changelog);
            $this->view->changelog = $changelog_html;*/
        }

        $this->helper->title($this->helper->at('Cms Admin Panel'), true);

        $this->helper->activeMenu()->setActive('admin-home');

    }

    public function loginAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $form = new LoginForm();

        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                if ($form->isValid($this->request->getPost())) {
                    $login = $this->request->getPost('login', 'string');
                    $password = $this->request->getPost('password', 'string');
                    $user = AdminUser::findFirst("login='$login'");
                    if ($user) {
                        if ($user->checkPassword($password)) {
                            if ($user->isActive()) {
                                $this->session->set('auth', $user->getAuthData());
                                $this->flash->success($this->helper->translate("Witamy w panelu administracyjnym"));
                                return $this->redirect($this->url->get() . 'admin');
                            } else {
                                $this->flash->error($this->helper->translate("Użytkownik nie został aktywowany"));
                            }
                        } else {
                            $this->flash->error($this->helper->translate("Niepoprawny login lub hasło"));
                        }
                    } else {
                        $this->flash->error($this->helper->translate("Niepoprawny login lub hasło"));
                    }
                } else {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                }
            } else {
                $this->flash->error($this->helper->translate("Wystąpił błąd autoryzacji"));
            }
        }

        $this->view->form = $form;

    }

    public function logoutAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                $this->session->remove('auth');
            } else {
                $this->flash->error("Wystąpił błąd autoryzacji");
            }
        } else {
            $this->flash->error("Wystąpił błąd");
        }
        $this->redirect($this->url->get());
    }

}
