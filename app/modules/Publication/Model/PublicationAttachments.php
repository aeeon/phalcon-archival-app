<?php

namespace Publication\Model;

use Application\Mvc\Model\Model;
use Publication\Model\Publication;

class PublicationAttachments extends Model {

    public function getSource() {
        return "publication_attachments";
    }

    public $id;
    public $title;
    public $name;
    public $path;
    public $publication_id;

    public function initialize() {
        $this->belongsTo('publication_id', 'Publication', 'id', ['alias' => 'publication']);
    }

    public function beforeCreate() {
    }

    public function beforeUpdate() {
    }

    public function updateFields($data) {
        
    }

    public function validation() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->path;
    }

    public function getPublication_id() {
        return $this->publication_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setPublication_id($publication_id) {
        $this->publication_id = $publication_id;
    }


}
