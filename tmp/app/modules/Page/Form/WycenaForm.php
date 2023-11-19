<?php

/**
 * Created by PhpStorm.
 * User: office-pb1
 * Date: 07.07.14
 * Time: 22:48
 */

namespace Page\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Porady\Model\Porady;

class WycenaForm extends Form {

    public function initialize() {
        $text = new TextArea('text', array('required' => true, 'placeholder'=>'Treść wiadmości'));
        $text->addValidator(
                new PresenceOf(
                array(
            'message' => 'Podanie pytania jest wymagane'
                )
                )
        );
        $this->add($text);

        $item = new Text('name', array(
            'required' => true,
            'placeholder'=>'Imię, nazwisko',
            'maxlength' => 120));
        $item->addValidator(
                new StringLength(
                array(
            'min' => 5,
            'max' => 120,
            'messageMinimum' => 'Wpisane imię i nazwisko jest zbyt krótkie',
            'messageMaximum' => 'Wpisane imię i nazwisko jest zbyt długie'
                )
                )
        );
        $this->add($item);

        $item = new Email('email', array(
            'required' => true,
            'placeholder' => 'E-mail',
            'maxlength' => 255));
     //   $item->setLabel('E-mail');
        $item->addValidator(
                new StringLength(
                array(
            'min' => 5,
            'max' => 255,
            'messageMinimum' => 'Wpisany adres e-mail jest zbyt krótki',
            'messageMaximum' => 'Wpisany adres e-mail jest zbyt długi'
                )
                )
        );
        $this->add($item);

        $item = new Text('phone', array('placeholder'=>'Nr telefonu', 'required'=>true));
       // $item->setLabel('Telefon');
        $item
                /*->addValidator(
                new PresenceOf(array(
                    'message' => 'Telefon jest wymagany',
                    'cancelOnFail' => true
                )))*/
                ->addValidator(new Regex(array(
                    'message' => 'Podany telefon jest niepoprawny',
                    'pattern' => '/^([0-9\(\)\/\+ \-]*)$/'
                )))
                ->addValidator( new StringLength(array(
                    'messageMinimum' => 'Wpisany numer telefonu jest zbyt krótki',
                    'min' => 4
        )));
        $this->add($item);

        /*$item = new Select('province', Porady::getProvinceList());
        $item->setLabel('Województwo');
        $this->add($item);*/

        $item = new Check('zgoda1', array('required' => true));
      //  $item->setLabel('Chcę otrzymać bezpłatną wycenę mojego problemu, akceptuję regulamin usługi oraz regulamin serwisu. ');
        $this->add($item);
 
                $item = new Check('zgoda2', array('required' => true));
     //   $item->setLabel('Wyrażam zgodę na przetwarzanie moich danych osobowych w celu wykonania zobowiązań przez zgodnie z ustawą z 29 sierpnia 1997 r. o ochronie danych osobowych.  ');
        $this->add($item);
    }

}
