<?php

namespace Comment\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Check;

class CommentForm extends Form {

    public function initialize() {
        $title = new Text('name', array('required' => true));
        $title->setLabel('Imię i nazwisko');
        $this->add($title);

        $email = new Email('email', array('required' => true));
        $email->setLabel('Email');
        $this->add($email);

        $text = new TextArea('content');
        $text->setLabel('Treść');
        $this->add($text);
        
        $date = new Text('created_at');
        $date->setLabel('Data publikacji');
        $this->add($date);
        
        $status = new Check('status');
        $status->setLabel('Status');
        $this->add($status);
    }

}
