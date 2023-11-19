<?php

namespace Treemenu\Mvc;

use Phalcon\Mvc\User\Component;
use Treemenu\Model\Category;

class Helper extends Component
{

    public function treeUpperLeafs($root)
    {
        return Category::treeUpperLeafs($root);
    }

}