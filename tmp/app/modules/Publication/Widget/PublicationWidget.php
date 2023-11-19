<?php

/**
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.net)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Publication\Widget;

use Application\Widget\AbstractWidget;

class PublicationWidget extends AbstractWidget {

    public function lastNews($cat_id, $limit = 4) {
        $model = \Tree\Model\Category::findFirst($cat_id);
        /*  $qb = $this->modelsManager->createBuilder();
          $qb->addFrom('Publication\Model\Publication', 'p');
          $qb->leftJoin('Publication\Model\Type', null, 't');
          $qb->andWhere('t.id= :type:', ['type' => $type_id]);
          $qb->andWhere('p.date <= NOW()');
          $qb->orderBy('p.date DESC');
          $qb->limit($limit);

          $entries = $qb->getQuery()->execute(); */

        $phql = "SELECT p.* FROM Publication\Model\Publication AS p INNER JOIN  Publication\Model\PublicationCategories pc ON p.id = pc.publication_id "
                . "INNER JOIN Tree\Model\Category c ON c.id = pc.category_id AND c.left_key >= '{$model->getLeftKey()}' AND c.right_key <= '{$model->getRightKey()}'";
        $phql .= " WHERE p.type_id='2' 
    AND p.date <= NOW()
    AND p.status = 'publish'";

        $phql .= "GROUP BY p.id ORDER BY p.date DESC LIMIT $limit";

        $query = $this->modelsManager->createQuery($phql);

        $query->cache(
                array(
                    "key" => md5('lastNews' . $model->getSlug()),
                    "lifetime" => 360
                )
        );
        $entries = $query->execute();
        $this->widgetPartial('widget/last-news', ['entries' => $entries]);
    }

    public function popularArticles($cat_id = null, $limit = 3) {
        $model = \Tree\Model\Category::findFirst($cat_id);
        $phql = "SELECT p.* FROM Publication\Model\Publication AS p ";
              //  . "INNER JOIN  Publication\Model\PublicationCategories pc ON p.id = pc.publication_id "
                //. "INNER JOIN Tree\Model\Category c ON c.id = pc.category_id AND c.left_key >= '{$model->getLeftKey()}' AND c.right_key <= '{$model->getRightKey()}'";
        $phql .= " WHERE p.type_id='2' 
    AND p.date <= NOW()
    AND p.status = 'publish'";
//GROUP BY p.id 
        $phql .= "ORDER BY p.date DESC LIMIT $limit";

        $query = $this->modelsManager->createQuery($phql);

        $query->cache(
                array(
                    "key" => md5('lastNews' . $model->getSlug()),
                    "lifetime" => 360
                )
        );
        $entries = $query->execute();

        $this->widgetPartial('widget/popular-articles', ['entries' => $entries]);
    }

    public function similarArticles($current_id, $cat_id = null, $limit = 3) {
        $model = \Tree\Model\Category::findFirst($cat_id);
        $phql = "SELECT p.* FROM Publication\Model\Publication AS p "
                . "INNER JOIN  Publication\Model\PublicationCategories pc ON p.id = pc.publication_id "
                . "INNER JOIN Tree\Model\Category c ON c.id = pc.category_id AND c.left_key >= '{$model->getLeftKey()}' AND c.right_key <= '{$model->getRightKey()}'";
        $phql .= " WHERE p.type_id='2' 
    AND p.date <= NOW()
    AND p.status = 'publish' AND p.id <> '{$current_id}'";
        $phql .= "GROUP BY p.id  ORDER BY p.date DESC LIMIT $limit";

        $query = $this->modelsManager->createQuery($phql);

        $query->cache(
                array(
                    "key" => md5('lastNews' . $model->getSlug()),
                    "lifetime" => 360
                )
        );
        $entries = $query->execute();        

        $this->widgetPartial('widget/similar-articles', ['entries' => $entries]);
    }

}
