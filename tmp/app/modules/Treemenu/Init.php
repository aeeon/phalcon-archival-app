<?php

namespace Treemenu;

use Phalcon\Mvc\User\Component;
use Treemenu\Mvc\Helper;

class Init extends Component
{

    public function __construct()
    {
        $this->getDi()->set('treemenu_helper', new Helper());
    }

}