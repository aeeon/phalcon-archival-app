<?php

namespace Publication\Controller;

use Application\Mvc\Controller;
use Publication\Model\Publication as Publication;
use Publication\Form\PublicationForm;
use Publication\Model\Type;
use Phalcon\Mvc\Model\Resultset;
use Admin\Model\AdminUser;

class AdminController extends Controller {

    public function initialize() {
        $this->setAdminEnvironment();
        $this->helper->activeMenu()->setActive('admin-publication');
    }

    public function indexAction() {
        $page = $this->request->getQuery('page', 'int', 1);
        $sort = $this->request->getQuery('sort', 'string', 'updated_at');
        $asc = $this->request->getQuery('asc', 'string', 'DESC');
        $type = $this->request->getQuery('type', 'string');
        $user = $this->session->get('auth');

        $search = $this->request->getQuery('search', "string", "");

        $qb = $this->modelsManager->createBuilder();
        // $qb->distinct('p.id');
        $qb->addFrom('Publication\Model\Publication', 'p');
        $qb->leftJoin('Publication\Model\Translate\PublicationTranslate', "p.id = t.foreign_id AND (t.key='title' OR t.key='text')", 't');

        $qb->andWhere('t.lang = :lang:', ['lang' => LANG]);
        if ($search) {
            $qb->andWhere("(t.value LIKE CONCAT('%', ?0, '%') AND t.key = 'text') OR (t.value LIKE CONCAT('%', ?1, '%') AND t.key = 'title')", array($search, $search));
        } else {
            //  $qb->andWhere('t.key = :key:', ['key' => 'title']);
        }

        $qb->groupBy('p.id');
        if (empty($type))
            $type = $this->dispatcher->getParam('type');

        $type_id = null;
        $types = Type::find();

        $cond_array = [];
        if ($type) {
            $typeEntity = Type::getCachedBySlug($type);
            $type_id = $typeEntity->getId();
            $qb->andWhere('p.type_id = :type:', ['type' => $type_id]);
        }

        $role = AdminUser::getRoleById($user->id);

        if (strcmp($role, "admin")) {
            $qb->andWhere('p.user_id = :user:', ['user' => $user->id]);
        }

        if ($sort == 'title')
            $qb->orderBy("t.value $asc");
        else
            $qb->orderBy("p.$sort $asc");

       // $qb->limit(20);

        // print_r( $qb->getQuery()->getSql());exit;
        $publications = $qb->getQuery()->execute();

        $paginator = new \Phalcon\Paginator\Adapter\Model([
            "data" => $publications,
            "limit" => 20,
            "page" => $page
        ]);
        $this->view->paginate = $paginator->getPaginate();

        $this->view->search = $search;
        $this->view->types = $types;
        $this->view->type = $type;
        $this->view->type_id = $type_id;

        if ($asc == 'DESC') {
            $asc = 'ASC';
        } else if ($asc == 'ASC') {
            $asc = 'DESC';
        }
        $this->view->asc = $asc;
        $this->view->sort = $sort;

        $this->helper->title($this->helper->at('Publikacje'), true);
    }

    public function addAction() {
        $this->view->pick(['admin/edit']);
        $form = new PublicationForm();
        $model = new Publication();
        $user = $this->session->get('auth');
        $model->setUserId($user->id);


        $type = $this->dispatcher->getParam('type');
        if ($type) {
            $typeEntity = Type::getCachedBySlug($type);
            $form->get('type_id')->setDefault($typeEntity->getId());
            $this->view->type = $type;
        }

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->bind($post, $model);

            if ($form->isValid()) {
                if ($model->create()) {
                    $form->bind($post, $model);
                    $model->updateFields($post);
                    if ($model->update()) {
                        $this->uploadImage($model);
                        $this->flash->success($this->helper->at('Publikacja dodana'));
                        return $this->redirect($this->url->get() . 'publication/admin/edit/' . $model->getId() . '?lang=' . LANG);
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

        $this->helper->title($this->helper->at('Dodaj publikacje'), true);
    }

    public function deleteItemAction() {
        $this->view->disable();
        if ($this->request->isDelete()) {
            $path = $this->request->getQuery('path');
            $fullPath = APPLICATION_PATH . '/../' . $path;
            if (file_exists($fullPath)) {
                unlink($fullPath);
                $name = basename($fullPath);
                echo json_encode(array('files' => array($name)));
                return;
            }
            echo json_encode(array('status' => 'file exists'));
            return;
        }
        echo json_encode(array('status' => 'method not allowed'));
        return;
    }

    /* public function deleteItemAction() {
      if (!$this->request->isDelete() || !$this->request->isAjax()) {
      return $this->flash->error('delete ajax required');
      }

      if ($this->request->isDelete()) {
      $path = $this->request->getQuery('path');
      $fullPath = APPLICATION_PATH . '/../' . $path;
      if (file_exists($fullPath)) {
      unlink($fullPath);
      $name = basename($fullPath);
      $this->returnJSON(['files' => array($name)]);
      }
      $this->returnJSON(['errors' => "File exists"]);
      }
      } */

    public function uploadAction($id) {
         
       
        $this->view->disable();
        $url = $this->getDI()->get('url');
        $path = 'public/docs/' . $id . '/';
        $upload_dir = APPLICATION_PATH . '/../public/docs/' . $id;
        
        $delete_url = $url->path() . 'publication/admin/deleteItem?path=' . $path;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir);
        }

        if ($this->request->isPost() && $this->request->hasFiles() !== false) {

// Simple validation (max file size 50MB and allowed mime types)
            $validator = new \FileUpload\Validator\Simple("16M", [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/msword'
            ]);

// Simple path resolver, where uploads will be put
            $pathresolver = new \FileUpload\PathResolver\Simple($upload_dir);

// The machine's filesystem
            $filesystem = new \FileUpload\FileSystem\Simple();

// FileUploader itself
            $fileupload = new \FileUpload\FileUpload($_FILES['files'], $_SERVER);
            $filenamegenerator = new \FileUpload\FileNameGenerator\Simple();
            $fileupload->setFileNameGenerator($filenamegenerator);

// Adding it all together. Note that you can use multiple validators or none at all
            $fileupload->setPathResolver($pathresolver);
            $fileupload->setFileSystem($filesystem);
            $fileupload->addValidator($validator);

// Doing the deed
            list($files, $headers) = $fileupload->processAll($delete_url);

// Outputting it, for example like this
            foreach ($headers as $header => $value) {
                header($header . ': ' . $value);
            }

            echo json_encode(array('files' => $files));
        } else if ($this->request->isGet()) {
          
            if (!is_dir($upload_dir)) {
                echo json_encode(array());
            }
            echo json_encode($this->dirToArray($upload_dir, $path));
        }
     
        
    }

    private function dirToArray($dir, $path) {
        
        $result = array();

        $cdir = scandir($dir);
        $url = $this->getDI()->get('url');
       


        foreach ($cdir as $key => $value) {
             $file = new \stdClass();
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    continue;
                } else {
                    $fullPath = APPLICATION_PATH . '/../' . $path . $value;
                    $file->name = $value;
                    $file->url = $url->path() . $path . $value;
                    $file->deleteType = "DELETE";
                    $file->size = filesize($fullPath);
                    $file->deleteUrl = $url->path() . 'publication/admin/deleteItem?path=' . $path . $value;
                    $result['files'][] = $file;
                }
            }
        }

        return $result;
    }

    public function editAction($id) {
        $id = (int) $id;

        
        $model = Publication::findFirst($id);
        $user = $this->session->get('auth');

        if ($model->getType_id()) {
            $this->view->type = $model->getType()->getSlug();
        }
        if ($model->getUserId() == 0) {
            $model->setUserId($user->id);
        }
        $form = new PublicationForm($model, ['type' => $model->getType()->getSlug()]);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            $form->bind($post, $model);

            if ($form->isValid()) {
                $model->updateFields($post);
                if ($model->save()) {
                    $this->uploadImage($model);
                    $this->flash->success($this->helper->at('Publikacja została zaktualizowana'));

                    return $this->redirect($this->url->get() . 'publication/admin/edit/' . $model->getId() . '?lang=' . LANG);
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
        $this->helper->title($this->helper->at('Edytuj publikacje'), true);
    }

    public function deleteAction($id) {
        $model = Publication::findFirst($id);


        if ($this->request->isPost()) {
            $deleteComments = $this->request->getPost('deleteComments');
            if ($deleteComments) {
                foreach ($model->comments as $comment) {
                    \Comment\Model\Comment::findFirst($comment->getId())->delete();
                }
            }

            $model->delete();
            if ($model->getType_id()) {
                $this->redirect($this->url->get() . 'publication/admin/' . $model->getType()->getSlug());
            } else {
                $this->redirect($this->url->get() . 'publication/admin');
            }
        }

        $this->view->model = $model;
        $this->helper->title($this->helper->at('Usuwanie'), true);
    }

    private function uploadImage($model) {
        if ($this->request->isPost()) {
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    if (!$file->getTempName()) {
                        return;
                    }
                    if (!in_array($file->getType(), [
                                'image/jpeg',
                                'image/png',
                            ])
                    ) {
                        return $this->flash->error($this->helper->at('Dopuszczalne formaty obrazków to jpg, jpeg, png'));
                    }

                    $imageFilter = new \Image\Storage([
                        'id' => $model->getId(),
                        'type' => 'publication',
                    ]);
                    $imageFilter->removeCached();

                    $resize_x = 1000;
                    $image = new \Phalcon\Image\Adapter\GD($file->getTempName());
                    if ($image->getWidth() > $resize_x) {
                        $image->resize($resize_x, null, \Phalcon\Image::WIDTH);
                    }
                    $image->save($imageFilter->originalAbsPath());

                    $model->setPreviewSrc($imageFilter->originalRelPath());
                    $model->update();

                    $this->flash->success($this->helper->at('Obrazek został dodany'));
                }
            }
        }
    }

}
