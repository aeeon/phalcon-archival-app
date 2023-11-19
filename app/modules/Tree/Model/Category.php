<?php

/**
 * @copyright Copyright (c) 2011 - 2015 Oleksandr Torosh (http://yonastudio.com)
 * @author Oleksandr Torosh <webtorua@gmail.com>
 */

namespace Tree\Model;

use Application\Mvc\Model\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Application\Mvc\Helper\CmsCache;
use Phalcon\DI;

class Category extends Model {

    public function getSource() {
        return "tree_category";
    }

    protected $translateModel = 'Tree\Model\Translate\CategoryTranslate'; // translate
    private $id;
    private $root = 'biznes';
    private $parent_id;
    private $slug;
    private $depth = 0;
    private $left_key;
    private $right_key;
    private $created_at;
    private $updated_at;
    public $title; // translate
    public static $roots = [
        'biznes' => 'Biznes',
        'dom' => 'Dom',
        'dokumenty' => 'Dokumenty'
    ];

    public function initialize() {
        $this->belongsTo('parent_id', 'Category\Model\Category', 'id', ['alias' => 'Parent']);
        $this->hasMany("id", $this->translateModel, "foreign_id"); // translate
        $this->hasManyToMany(
            "id",
            "Publication\Model\PublicationCategories",
            "category_id",
            "publication_id",
            "Publication\Model\Publication",
            "id",
            array('alias' => 'publications')
        );        
    }

    public function validation() {
        $this->validate(new Uniqueness(
                [
            "field" => "slug",
            "message" => "Kategoria z tym slugiem '" . $this->slug . "' właśnie istnieje. Wybierz inny tytuł."
                ]
        ));

        return $this->validationHasFailed() != true;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $cache = $this->getDi()->get('cache');
        $cache->delete(self::cacheSlugKey($this->getSlug()));
    }

    public function afterSave() {
        CmsCache::getInstance()->save('publication_cats', $this->buildCmsCatsCache());
    }

    public function afterDelete() {
        CmsCache::getInstance()->save('publication_cats', $this->buildCmsCatsCache());
    }

    private function buildCmsCatsCache() {
        $cats = self::find([
                    'order' => 'left_key',
        ]);
        $save = [];
        foreach ($cats as $cat) {
            $save[$cat->getSlug()] = [
                'id' => $cat->getId(),
                'slug' => $cat->getSlug(),
            ];
        }
        return $save;
    }

    public static function cats() {
        return CmsCache::getInstance()->get('publication_cats');
    }

    public static function getListArray($root) {
        $list = [];
        $list['0'] = "---";

        $result = self::find([
                    'order' => 'root',
                    'conditions' => "depth = 1 AND root='{$root}'"
        ]);
        // strony dynamiczne
        $prev = null;
        foreach ($result as $el) {
            $root = $el->getRoot();
            $klucz =$el->getId();
            $value = $el->getTitle();
            $list[$klucz] = $value;


            $result_sub = self::find([
                        'conditions' => "depth = '2' AND parent_id='{$el->getId()}'",
                        'order' => 'left_key',
            ]);
            foreach ($result_sub as $el_sub) {
                $kklucz = $el_sub->getId();
                $ident = "";
                for ($i = 1; $i < $el_sub->getDepth(); $i++)
                    $ident .= "--";
                  
                $vvalue = $ident .$el_sub->getTitle();
                $list[$kklucz] = $vvalue;
            }
        }
       
      /*  $cond = NULL;
        if ($root) {
            $cond = "root = '{$root}'";
        }
        $result = self::find([
                    "conditions" => $cond,
                    'order' => 'parent_id',
        ]);
        $list = [];
        $list['0'] = "---";
        foreach ($result as $el) {
            if (isset($params['value']) && $params['value']) {
                $value = $el->{$params['value']};
                if (empty($value))
                    $value = $params['key'];
            } else {
                $value = $el->getTitle();

                if (empty($value))
                    $value .= $el->getSlug();

                $ident = "";
                for ($i = 1; $i < $el->getDepth(); $i++)
                    $ident .= "--";
                $value = $ident . $value;
            }
            if (isset($params['key']) && $params['key']) {
                $list[$el->{$params['key']}] = $value;
            } else {
                $list[$el->getId()] = $value;
            }
        }*/

        return $list;
    }

    public static function getUrlArray() {

        $list = [];
        $list['0'] = "---";
        //strony statyczne
        $result = \Page\Model\Page::find();
        foreach ($result as $el) {
            $slug = $el->getSlug() .  ".html";
            $klucz = json_encode(['type'=>'page', 'item_id'=>$el->getId()]);
            $list[$klucz] = $slug;
        }

        $result = self::find([
                    'order' => 'root',
                    'conditions' => "depth = 1"
        ]);
        // strony dynamiczne
        $prev = null;
        foreach ($result as $el) {
            $root = $el->getRoot();
            $slug = $el->getSlug();
            if ($prev != $root) {
                $item = \Publication\Model\Type::getCachedBySlug($root);
                $klucz = json_encode(['type'=>'type', 'item_id'=>$item->getId()]);
                $list[$klucz] = $root;
            }
            $value = $root . "/" . $slug;
            $klucz = json_encode(['type'=>'category', 'item_id'=>$el->getId()]);
            $list[$klucz] = $value;

           /* $result_pub = \Publication\Model\Publication::find([
                        'conditions' => "category_id = '{$el->getId()}'",
            ]);
            foreach ($result_pub as $el_pub) {
                $key = $value . "/" . $el_pub->getSlug() . ".html";
                $klucz = json_encode(['type'=>'publication', 'item_id'=>$el_pub->getId()]);
                $list[$klucz] = $key;
            }*/

            $result_sub = self::find([
                        'conditions' => "depth = '2' AND parent_id='{$el->getId()}'",
                        'order' => 'left_key',
            ]);
            foreach ($result_sub as $el_sub) {
                $key = $value . "/" . $el_sub->getSlug();
                $klucz = json_encode(['type'=>'category', 'item_id'=>$el_sub->getId()]);
                $list[$klucz] = $key;

                /*$result_spub = \Publication\Model\Publication::find([
                            'conditions' => "category_id = '{$el_sub->getId()}'",
                ]);
                foreach ($result_spub as $el_spub) {
                    $skey = $key . "/" . $el_spub->getSlug() . ".html";
                      $klucz = json_encode(['type'=>'publication', 'item_id'=>$el_spub->getId()]);
                      $list[$klucz] = $skey;
                }*/
            }
        }

        return $list;
    }

    public static function getCachedBySlug($slug) {
        $data = self::findFirst([
                    'slug = :slug:',
                    'bind' => [
                        'slug' => $slug,
                    ],
                    'cache' => [
                        'key' => self::cacheSlugKey($slug),
                        'lifetime' => 86400,
                    ]
        ]);

        return $data;
    }

    public static function cacheSlugKey($slug) {
        return HOST_HASH . md5('Category\Model\Category; slug = ' . $slug);
    }

    public static function cacheListKey($params) {
        return HOST_HASH . md5('Category\Model\Category; list; ' . serialize($params));
    }

    public function beforeCreate() {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function beforeUpdate() {
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public static function getByType($root) {
        $entries = Category::find([
                    'root = :root:',
                    'order' => 'left_key',
                    'bind' => ['root' => $root]
        ]);
        return $entries;
    }

    public static function treeUpperLeafs($root) {
        $entries = Category::find([
                    'root = :root: AND parent_id IS NULL',
                    'order' => 'left_key',
                    'bind' => ['root' => $root]
        ]);
        return $entries;
    }
    public static function getCachedById($id) {
        $query = "id = '$id'";
        $key = HOST_HASH . md5("\Tree\Model\Category::findFirst($query)");
        $cat = self::findFirst(array($query, 'cache' => array('key' => $key, 'lifetime' => 360)));   
        return $cat;
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

    /**
     * @return mixed
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
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

}
