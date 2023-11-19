<?php

namespace Page\Controller;

use Application\Mvc\Controller;
use Page\Model\Page;
use Phalcon\Mvc\Dispatcher\Exception;
use Page\Form\WycenaForm;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class IndexController extends Controller {

    public function indexAction() {
        $slug = $this->dispatcher->getParam('slug', 'string');
        $page = Page::findCachedBySlug($slug);
        if (!$page) {
            throw new Exception("Page '$slug.html' not found");
        }

        $this->helper->title()->append($page->getMetaTitle());
        $this->helper->meta()->set('description', $page->getMetaDescription());
        $this->helper->meta()->set('keywords', $page->getMetaKeywords());

        $this->view->page = $page;
    }

    public function contactsAction() {
        $page = Page::findCachedBySlug('kontakt');
        if (!$page) {
            throw new Exception("Page 'contacts' not found");
        }

        if ($this->request->isPost()) {
            $validation = new Validation();

            $validation->add(
                    'imie_nazwisko', new PresenceOf(
                    array(
                'message' => 'Imię i nazwisko jest wymagane'
                    )
                    )
            );
            $validation->add(
                    'wiadomosc', new PresenceOf(
                    array(
                'message' => 'Treść wiadomości jest wymagana'
                    )
                    )
            );
            $validation->add(
                    'email', new PresenceOf(
                    array(
                'message' => 'Email jest wymagany'
                    )
                    )
            );

            $validation->add(
                    'email', new Email(
                    array(
                'message' => 'Podany e-mail jest niepoprawny'
                    )
                    )
            );

            $messages = $validation->validate($_POST);
            if (count($messages)) {
                $this->flash->error(implode("<br>", $messages));
            } else {
                $email = $this->request->getPost('email', 'string');
                $tel = $this->request->getPost('tel', 'string');
                $name = $this->request->getPost('imie_nazwisko', 'string');
                $wiadomosc = $this->request->getPost('wiadomosc', 'string');
                $mail = $this->di->get("mailer");
                $mail->Subject = "Kontakt ze strony - jakprawnie.pl";
                //<br><br>Imię i nazwisko: " . $name . "<br><br>Email: " . $email . 
                $mail->Body = $wiadomosc . "<br>----<br>Telefon: " . $tel;
                $mail->setFrom($email, $name);
                //  $mail->addAddress($email, "Jakprawnie");     // Add a recipient

                if ($mail->send()) {
                    $this->flash->success($this->helper->at('Dziękujemy za wysłanie wiadomości.'));
                    /* $this->returnJSON([
                      'success' => true,
                      'email' => $email,
                      ]); */
                } else {
                    $this->flash->error($mail->ErrorInfo);
                    // $this->returnJSON(['error' => $mail->ErrorInfo]);
                }
            }
        }
        $this->helper->title()->append($page->getMetaTitle());
        $this->helper->meta()->set('description', $page->getMetaDescription());
        $this->helper->meta()->set('keywords', $page->getMetaKeywords());
        $this->view->page = $page;

        $this->helper->menu->setActive('kontakt');
    }

    public function wycenaAction() {
        $page = Page::findCachedBySlug('wycena');
        if (!$page) {
            throw new Exception("Page 'wycena' not found");
        }

        $form = new WycenaForm();
        $model = new \Porady\Model\Porady();
        $mail = $this->di->get("mailer");
        $uploader = $this->di->get('uploader');

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);
            $valid = true;
            if ($form->isValid()) {

                $mail->Subject = "Porada prawna - jakprawnie.pl";
                $mail->Body = $model->getText() . "<br><br>Telefon: " . $model->getPhone();
                ;
                if ($this->request->hasFiles() == true) {
                    if ($uploader->isValid() === true) {
                        $uploader->move(); // upload files array result
                        //  $this->flash->warning(implode("<br>", $uploader->getInfo()));
                        // print_r($uploader->getInfo()); // var dump to see upload files

                        foreach ($uploader->getInfo() as $file) {
                            $mail->addAttachment($file['path']);
                        }
                    } else {
                        $this->view->form = $form;
                        $this->flash->error(implode("<br>", $uploader->getErrors()));
                        $valid = false;
                        // return $this->redirect($this->url->get() . 'wycena.html' . '?lang=' . LANG);
                    }
                }
                $mail->setFrom($model->getEmail(), $model->getName());
                //$mail->addAddress($model, "Jakprawnie");     // Add a recipient

                if ($valid)
                    if ($mail->send()) {

                        $this->flash->success($this->helper->at('Pytanie zostało wysłane. Dziękujemy.'));
                        // return $this->redirect($this->url->get() . 'page/admin/edit/' . $model->getId() . '?lang=' . LANG);
                    } else {
                        $this->flash->error($mail->ErrorInfo);
                        //$this->flashErrors("Wystąpił błąd podczas wysyłania");
                    }
                $uploader->truncate();
            } else {
                $this->view->form = $form;
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                //$this->flash->error($this->helper->at('Wystąpiły błędy w formularzu.'));
            }
        } else {
            $this->view->form = $form;
        }

        $this->helper->title()->append($page->getMetaTitle());
        $this->helper->meta()->set('description', $page->getMetaDescription());
        $this->helper->meta()->set('keywords', $page->getMetaKeywords());
        $this->view->page = $page;


        $this->helper->menu->setActive('wycena');
    }

    public function newsletterAction() {
        /*  if (!$this->request->getPost() || !$this->request->isAjax()) {
          return $this->flash->error('post ajax required');
          } */

        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', 'string');
            $mail = $this->di->get("mailer");
            $mail->Subject = "Zapisanie do newslettera - jakprawnie.pl";
            $mail->Body = "Dziękujemy " . $email . " za zapisanie się do newslettera.";
            $mail->setFrom($email, $email);
            $mail->addAddress($email, "Jakprawnie");     // Add a recipient

            if ($mail->send()) {
                $this->flash->success($this->helper->at('Dziękujemy za zapisanie się do newslettera.'));
                /* $this->returnJSON([
                  'success' => true,
                  'email' => $email,
                  ]); */
            } else {
                $this->flash->error($mail->ErrorInfo);
                // $this->returnJSON(['error' => $mail->ErrorInfo]);
            }
        }
    }



}
