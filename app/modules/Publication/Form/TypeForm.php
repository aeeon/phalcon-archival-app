<?php
/**
 * @copyright Copyright (c) 2011 - 2014 Oleksandr Torosh (http://wezoom.net)
 * @author Oleksandr Torosh <web@wezoom.net>
 */

namespace Publication\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
use Publication\Model\Type;

class TypeForm extends Form
{

    public function initialize()
    {
        $this->add((new Text('title', array('required' => true)))->setLabel('Tytuł'));
        $this->add((new Text('slug', array('required' => true, 'disabled'=>true, 'data-description' => '')))->setLabel('URL'));
        $this->add((new Text('head_title'))->setLabel('Tytuł w HEAD'));
        $this->add((new Text('meta_description'))->setLabel('Meta-description'));
        $this->add((new Text('meta_keywords'))->setLabel('Meta-keywords'));
        $this->add((new TextArea('seo_text'))->setLabel('Dodatkowy opis (dla seo)'));
        $this->add((new Text('limit', array('style' => 'width:106px')))->setDefault(10)->setLabel('Ilość publikacji na stronę'));
        $this->add((new Select('format', Type::$formats))->setLabel('Sposób wyświetlania'));
        $this->add((new Check('display_date'))->setLabel('Wyświetlaj datę'));

    }

} 