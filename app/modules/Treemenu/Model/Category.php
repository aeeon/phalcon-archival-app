<?php

namespace Treemenu\Model;

use Application\Mvc\Model\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Application\Mvc\Helper\CmsCache;
use Phalcon\DI;

class Category extends Model {

    public function getSource() {
        return "menu";
    }

    protected $translateModel = 'Treemenu\Model\Translate\CategoryTranslate'; // translate
    private $id;
    private $root = 'top';
    private $parent_id;
    private $work_title;
    private $depth = 0;
    private $left_key;
    private $right_key;
    private $created_at;
    private $updated_at;
    private $newwindow;
    private $auto;
    private $data;
    private $status;
    public $title; // translate
    public $custom;
    public static $roots = [
        'top' => 'Top Menu',
        'footer1' => "Footer menu 1",
        'footer2' => "Footer menu 2",
    ];

    public function initialize() {
        $this->belongsTo('parent_id', 'Category\Model\Category', 'id', ['alias' => 'Parent']);
        $this->hasMany("id", $this->translateModel, "foreign_id"); // translate
    }
    public function updateFields($data) {
         $this->setStatus(isset($data['status']) ? 1 : 0);
        $this->setAuto(isset($data['auto']) ? 1 : 0);
        $this->setNewwindow(isset($data['newwindow']) ? 1 : 0);
    }
    public function validation() {
        
    }

    public function beforeCreate() {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function beforeUpdate() {
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public static function treeUpperLeafs($root) {
        $entries = Category::find([
                    'root = :root: AND parent_id IS NULL',
                    'order' => 'left_key',
                    'bind' => ['root' => $root]
        ]);
        return $entries;
    }

    public function children() {
        $entries = $this->find([
            'left_key >= :left_key: AND right_key <= :right_key: AND depth = :depth_plus: AND id <> :id: AND root = :root:',
            'order' => 'left_key ASC',
            'bind' => [
                'id' => $this->getId(),
                'root' => $this->getRoot(),
                'depth_plus' => $this->getDepth() + 1,
                'left_key' => $this->getLeftKey(),
                'right_key' => $this->getRightKey(),
            ]
        ]);
        return $entries;
    }

    public function hasChildren() {
        if (abs($this->getRightKey() - $this->getLeftKey()) > 1) {
            return true;
        }
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRoot() {
        return $this->root;
    }

    /**
     * @param string $root
     */
    public function setRoot($root) {
        $this->root = $root;
    }

    /**
     * @return mixed
     */
    public function getParentId() {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getDepth() {
        return $this->depth;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth) {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getLeftKey() {
        return $this->left_key;
    }

    /**
     * @param mixed $left_key
     */
    public function setLeftKey($left_key) {
        $this->left_key = $left_key;
    }

    /**
     * @return mixed
     */
    public function getRightKey() {
        return $this->right_key;
    }

    /**
     * @param mixed $right_key
     */
    public function setRightKey($right_key) {
        $this->right_key = $right_key;
    }

    public function getNewwindow() {
        return $this->newwindow;
    }

    public function setNewwindow($newwindow) {
        $this->newwindow = $newwindow;
    }
    public function getAuto() {
        return $this->auto;
    }

    public function setAuto($auto) {
        $this->auto = $auto;
    }

        /**
     * @return mixed
     */
    public function getTitle() {
        return $this->getMLVariable('title');
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->setMLVariable('title', $title);
    }
    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

        public function getCustom() {
        return $this->getMLVariable('custom');
    }


    public function setCustom($custom) {
        $this->setMLVariable('custom', $custom);
    }
    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->created_at;
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
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getWorkTitle() {
        return $this->work_title;
    }

    /**
     * @param mixed $work_title
     */
    public function setWorkTitle($work_title) {
        $this->work_title = $work_title;
    }

}
