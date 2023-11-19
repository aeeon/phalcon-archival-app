<?php

namespace Publication\Model;

use Application\Mvc\Model\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Application\Localization\Transliterator;
use Admin\Model\AdminUser;

class Publication extends Model {

    public function getSource() {
        return "publication";
    }

    protected $translateModel = 'Publication\Model\Translate\PublicationTranslate'; // translate
    protected $commentModel = 'Comment\Model\Comment';

    public function initialize() {
        $this->hasMany('id', $this->translateModel, 'foreign_id'); // translate
        $this->hasMany('id', $this->commentModel, 'foreign_key', [
            'alias'      => 'comments',
            'order'      => 'created_at DESC',
        ]);

        $this->belongsTo('category_id', 'Tree\Model\Category', 'id', [
            'alias' => 'Category'
        ]);
        $this->belongsTo('type_id', 'Publication\Model\Type', 'id', [
            'alias' => 'type'
        ]);
    }

    private $id;
    private $user_id;
    private $type_id;
    private $category_id;
    private $slug;
    protected $status;
    private $created_at;
    private $updated_at;
    private $date;
    private $preview_src;
    private $preview_inner;
    private $comments_enabled;
    private $paid_content;
    private $counter;
    protected $title;
    protected $text;
    protected $excerpt;
    protected $meta_title;
    protected $meta_description;
    protected $meta_keywords;

    public function beforeCreate() {
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function beforeUpdate() {
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $cache = $this->getDi()->get('cache');

        $cache->delete(self::cacheSlugKey($this->getSlug()));
    }

    public function validation() {
        $this->validate(new Uniqueness(
                [
            "field" => "slug",
            "message" => "Wpisany slug = '" . $this->slug . "' musi być unikalny"
                ]
        ));

        return $this->validationHasFailed() != true;
    }

    public function afterValidation() {
        if (!$this->date) {
            $this->date = date("Y-m-d H:i:s");
        }
    }

    public function updateFields($data) {

        if (!$this->getUserId()) {
            $this->setUserId($data['user_id']);
        }
        if (!$this->getSlug()) {
            $this->setSlug(Transliterator::slugify($data['title']));
        }
        if (!$this->getMetaTitle()) {
            $this->setMetaTitle($data['title']);
        }

        $this->setPreviewInner(isset($data['preview_inner']) ? 1 : 0);
        $this->setPaid_content(isset($data['paid_content']) ? 1 : 0);
        $this->setComments_enabled(isset($data['comments_enabled']) ? 1 : 0);
    }

    public function naliczWejscie() {
        if ($this->counter)
            $this->counter+=1;
        else
            $this->counter = 1;
        $this->update();
    }

    public static function findCachedBySlug($slug) {
        $publication = self::findFirst(["slug = '$slug'",
                    'cache' => [
                        'key' => self::cacheSlugKey($slug),
                        'lifetime' => 360]
        ]);
        return $publication;
    }

    public static function cacheSlugKey($slug) {
        $key = HOST_HASH . md5('Publication\Model\Publication; slug = ' . $slug);
        return $key;
    }

    public function getCounter() {
        return $this->counter;
    }

    public function setCounter($counter) {
        $this->counter = $counter;
    }

    public function getComments_enabled() {
        return $this->comments_enabled;
    }

    public function getPaid_content() {
        return $this->paid_content;
    }

    public function setComments_enabled($comments_enabled) {
        $this->comments_enabled = $comments_enabled;
    }

    public function setPaid_content($paid_content) {
        $this->paid_content = $paid_content;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getUsernameById() {
        return AdminUser::getUsernameById($this->user_id);
    }

    public static function getStatusArray() {
        return array("draft" => "Szkic", "publish" => "Opublikowany", "archive" => "Archiwum", "trash" => "Do kosza");
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setMetaDescription($meta_description) {
        $this->setMLVariable('meta_description', $meta_description);
    }

    public function getMetaDescription() {
        return $this->getMLVariable('meta_description');
    }

    public function setMetaKeywords($meta_keywords) {
        $this->setMLVariable('meta_keywords', $meta_keywords);
    }

    public function getMetaKeywords() {
        return $this->getMLVariable('meta_keywords');
    }

    public function setMetaTitle($meta_title) {
        $this->setMLVariable('meta_title', $meta_title);
    }

    public function getMetaTitle() {
        return $this->getMLVariable('meta_title');
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setText($text) {
        $this->setMLVariable('text', $text);
    }

    public function getText() {
        return $this->getMLVariable('text');
    }

    public function setExcerpt($excerpt) {
        $this->setMLVariable('excerpt', $excerpt);
    }

    public function getExcerpt() {
        return $this->getMLVariable('excerpt');
    }

    public function setTitle($title) {
        $this->setMLVariable('title', $title);
    }

    public function getTitle() {
        return $this->getMLVariable('title');
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate($format = 'Y-m-d H:i:s') {
        if ($format) {
            if ($this->date) {
                return date($format, strtotime($this->date));
            }
        } else {
            return $this->date;
        }
    }

    public function setType_id($type_id) {
        $this->type_id = $type_id;
    }

    public function getType_id() {
        return $this->type_id;
    }

    public function getCategory_id() {
        return $this->category_id;
    }

    public function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }

    public function getCatTitle($cat_id) {
        $cat = \Tree\Model\Category::findFirst($cat_id);
        if ($cat)
            return $cat->getTitle();
        return null;
    }

    public function getTypeTitle() {
        if ($this->type_id) {
            $types = Type::cachedListArray(['key' => 'id']);
            if (array_key_exists($this->type_id, $types)) {
                return $types[$this->type_id];
            }
        }
    }

    public function getTypeSlug() {
        if ($this->type_id) {
            $types = Type::cachedListArray(['key' => 'id', 'value' => 'slug']);
            if (array_key_exists($this->type_id, $types)) {
                return $types[$this->type_id];
            }
        }
    }

    public function setPreviewInner($preview_inner) {
        $this->preview_inner = $preview_inner;
    }

    public function getPreviewInner() {
        return $this->preview_inner;
    }

    public function getPreviewSrc() {
        return $this->preview_src;
    }

    public function setPreviewSrc($preview_src) {
        $this->preview_src = $preview_src;
    }

   /* public function getComments() {
        $comments = \Comment\Model\Comment::findFirst($cat_id);
        if ($cat)
            return $cat->getTitle();
        return null;
    }*/

}
