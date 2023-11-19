<?php
/**
 * @copyright Copyright (c) 2011 - 2015 Oleksandr Torosh (http://yonastudio.com)
 * @author Oleksandr Torosh <webtorua@gmail.com>
 */

namespace Menu\Form;

use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;

class MenuForm extends \Application\Form\Form
{

    public function initialize()
    {
        $this->add(
            (new Text('slug', ['required' => 'required']))
                ->addValidator(new PresenceOf([
                    'message' => 'Slug jest wymagany'
                ]))
                ->setLabel('Slug')
        );

        $this->add(
            (new Text('title', ['required' => 'required']))
                ->addValidator(new PresenceOf([
                    'message' => 'Tytuł jest wymagany'
                ]))
                ->setLabel('Tytuł')
        );

    }

}