<?php

namespace Treemenu\Form;

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\ExclusionIn;
use Tree\Model\Category;

class CategoryForm extends \Application\Form\Form {

    public function initialize() {
        $urls = new Select('data', Category::getUrlArray());
        $urls->setLabel('Url');
       /* $urls->addValidator(
                new PresenceOf(
                array(
            'message' => 'Wybór kategorii jest wymagany'
                )
                )
        );
        $urls->addValidator(
                new ExclusionIn(array(
            'message' => 'Wybór kategorii jest wymagany',
            'domain' => array('0', '---')
        )));*/

        $this->add($urls);


        $this->add(
                (new Text('title', ['required' => 'required']))
                        ->addValidator(new PresenceOf([
                            'message' => 'Tytuł jest wymagany'
                        ]))
                        ->setLabel('Tytuł')
        );
        $this->add(
                (new Text('custom'))
                        ->setLabel('Odnośnik (opcjonalnie)')
        );
        $item = new Check('status');
        $item->setLabel('Włącz/wyłącz');
        $this->add($item);
        
        $auto = new Check('auto');
        $auto->setLabel('Wstaw automatycznie elementy potomne');
        $this->add($auto);
        
        $neww = new Check('newwindow');
        $neww->setLabel('Otwórz w nowym oknie');
        $this->add($neww);        
    }

}
