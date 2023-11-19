<?php
/**
 * @copyright Copyright (c) 2011 - 2015 Oleksandr Torosh (http://yonastudio.com)
 * @author Oleksandr Torosh <webtorua@gmail.com>
 */

namespace Menu;

use Phalcon\Mvc\User\Component;
use Menu\Helper\Menu;

class Init extends Component
{

    public function __construct()
    {
        $this->getDi()->set('menu_helper', new Menu());
    }

}