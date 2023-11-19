<?php

namespace Comment\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Email;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;

class CommentFrontendForm extends Form {

    public function initialize() {
        $title = new Text('name', array('required' => true, 'placeholder' => 'Podpis'));
        $title->addValidator(new PresenceOf(array(
            'message' => 'Podpis jest wymagany'
        )));
        $this->add($title);

        $email = new Email('email', array('required' => true, 'placeholder' => 'E-mail'));
        $email->addValidator(new EmailValidator(array(
            'message' => 'Podany e-mail jest niepoprawny'
        )));
        $this->add($email);

        $text = new TextArea('content', array('required' => true, 'placeholder' => 'Treść wiadomości'));
        $text->addValidator(new PresenceOf(array(
            'message' => 'Treść jest wymagana'
        )));
        $this->add($text);
    }

}
