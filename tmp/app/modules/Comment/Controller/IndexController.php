<?php

namespace Comment\Controller;

use Application\Mvc\Controller;
use Comment\Model\Comment;
use Comment\Form\CommentForm;
use Phalcon\Mvc\Dispatcher\Exception;

class IndexController extends Controller {

    public function indexAction() {
        
    }

    public function addAction() {
        if (!$this->request->getPost() || !$this->request->isAjax()) {
            return $this->flash->error('post ajax required');
        }
        $model = new Comment();
        $form = new CommentForm();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $foreign_key = $this->request->getPost('foreign_key', 'int');


            $model->setForeign_key($foreign_key);
            $form->bind($post, $model);
            if ($form->isValid()) {

                if ($model->create()) {
                    $form->bind($post, $model);
                   // $model->updateFields($post);
                    if ($model->update()) {
                        $this->returnJSON([
                            'success' => true,
                            'id' => $model->getId(),
                            'content' => $model->getContent(),
                            'name' => $model->getName(),
                            'email' => $model->getEmail(),
                            'created_at' => $model->getCreatedAt()
                        ]);
                    } else {
                        $this->returnJSON(['error' => implode(' | ', $model->getMessages())]);
                    }
                } else {
                    $this->returnJSON(['error' => implode(' | ', $model->getMessages())]);
                }
            } else {
                $this->returnJSON(['error' => implode(' | ', $model->getMessages())]);
            }
        }
    }

}
