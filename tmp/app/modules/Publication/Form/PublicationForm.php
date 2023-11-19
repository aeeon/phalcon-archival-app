<?php
namespace Publication\Form;

use Application\Form\Element\Image;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Application\Form\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
use \Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Hidden;
use Publication\Model\Type;
use Publication\Model\Publication;
use Tree\Model\Category;

class PublicationForm extends Form {

    public function __construct($model, $arr) {
        $type = new Select('type_id', Type::cachedListArray(['key' => 'id']), array("onchange"=>"this.form.submit()"));
        $type->setLabel('Rodzaj publikacji');
        $this->add($type);

        $cat = new Select('category_id', Category::getListArray($arr['type']));
        $cat->setLabel('Kategoria');
        $this->add($cat);

        $status = new Select('status', Publication::getStatusArray());
        $status->setLabel('Status');
        $this->add($status);


        $title = new Text('title', ['required' => true]);
        $title->addValidator(new PresenceOf([
            'message' => 'Tytuł nie może być pusty'
        ]));
        $title->setLabel('Tytuł');
        $this->add($title);

        $slug = new Text('slug');
        $slug->setLabel('Slug');
        $this->add($slug);

        $date = new Text('date');
        $date->setLabel('Data publikacji');
        $this->add($date);

        $excerpt = new TextArea('excerpt');
        $excerpt->setLabel('Skrócony tekst (podglądowy)');
        $this->add($excerpt);

        $text = new TextArea('text');
        $text->setLabel('Pełny tekst');
        $this->add($text);

        $meta_title = new Text('meta_title', ['required' => true]);
        $meta_title->setLabel('meta_title');
        $this->add($meta_title);

        $meta_description = new TextArea('meta_description', ['style' => 'height:4em; min-height: inherit']);
        $meta_description->setLabel('meta_description');
        $this->add($meta_description);

        $meta_keywords = new TextArea('meta_keywords', ['style' => 'height:4em; min-height: inherit']);
        $meta_keywords->setLabel('meta_keywords');
        $this->add($meta_keywords);

        $preview_inner = new Check('preview_inner');
        $preview_inner->setLabel('Pokaż miniaturkę wewnątrz publikacji');
        $preview_inner->setDefault(1);
        $this->add($preview_inner);
        

        $comments_enabled = new Check('comments_enabled');
        $comments_enabled->setDefault(1);
        $comments_enabled->setLabel('Włącz/Wyłącz komentarze');
        $this->add($comments_enabled);

        $paid_content = new Check('paid_content');
        $paid_content->setLabel('Treść płatna');
        $this->add($paid_content);
        
        $item = new Text('counter', ['maxlength'=>6]);
        $item->setLabel('Licznik');
        $this->add($item);
        
        $image = new Image('preview_src');
        $image->setLabel('Miniaturka');
        $this->add($image);

        /*     $userid = new Hidden('user_id');
          $userid->setDefault(2);
          $this->add($userid); */
    }

}
