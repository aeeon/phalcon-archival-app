<?php

namespace Publication\Model;

use Application\Mvc\Model\Model;
use Publication\Model\Publication;

class PublicationCategories extends Model {

    public function getSource() {
        return "publication_categories";
    }

    public $id;
    public $category_id;
    public $publication_id;

    public function initialize() {
        $this->belongsTo('category_id', 'Tree\Model\Category', 'id', 
            array('alias' => 'category')
        );
        $this->belongsTo('publication_id', 'Publication\Model\Publication', 'id', 
            array('alias' => 'publication')
        );        
    }

    public function getId() {
        return $this->id;
    }

    public function getCategory_id() {
        return $this->category_id;
    }

    public function getPublication_id() {
        return $this->publication_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    public function setPublication_id($publication_id) {
        $this->publication_id = $publication_id;
    }




}
