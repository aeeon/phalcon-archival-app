<?php

namespace Page\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Text;
//use Phalcon\Forms\Element\TextArea;
//use Phalcon\Forms\Element\Check;

class NewsletterForm extends Form {

    public function initialize() {
        $email = new Text('email', array('required' => true, 'placeholder'=>'Zapisz się do newslettera'));
        $this->add($email);    
    }

}
