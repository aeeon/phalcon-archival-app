<?php

namespace Comment\Model;

use Application\Mvc\Model\Model;
use Publication\Model\Publication;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Application\Localization\Transliterator;

class Comment extends Model {

    public function getSource() {
        return "comment";
    }

    public $id;
    public $status;
    public $name;
    public $email;
    public $content;
    public $created_at;
    public $foreign_key;

    public function initialize() {
        $this->belongsTo('foreign_key', 'Publication', 'id', ['alias' => 'publication']);
    }

    public function beforeCreate() {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function beforeUpdate() {
        // $this->updated_at = date("Y-m-d H:i:s");
    }

    public function updateFields($data) {
        
    }

    public function validation() {
        
    }

    public static function findCachedBySlug($slug) {
        /*  $query = "slug = '$slug'";
          $key = HOST_HASH . md5("Page::findFirst($query)");
          $page = self::findFirst(array($query, 'cache' => array('key' => $key, 'lifetime' => 60)));
          return $page; */
    }

    public function getPublicationSlug() {
        $pub = Publication::findFirst($this->getForeign_key());
        if (!$pub) {
            return null;
        }
        return $pub->slug;
    }

    public function getTypeSlug() {
        $pub = Publication::findFirst($this->getForeign_key());
        if (!$pub) {
            return null;
        }
        return $pub->getTypeSlug();
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getContent() {
        return $this->content;
    }

    public function getForeign_key() {
        return $this->foreign_key;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setForeign_key($foreign_key) {
        $this->foreign_key = $foreign_key;
    }

}
