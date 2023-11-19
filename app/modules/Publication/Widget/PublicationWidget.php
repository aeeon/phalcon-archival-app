<?php

/**
 * @copyright Copyright (c) 2011 - 2014 Aleksandr Torosh (http://wezoom.net)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */

namespace Publication\Widget;

use Application\Widget\AbstractWidget;

class PublicationWidget extends AbstractWidget {

    public function lastNews($type_id, $limit = 4) {
        $qb = $this->modelsManager->createBuilder();
        $qb->addFrom('Publication\Model\Publication', 'p');
        $qb->leftJoin('Publication\Model\Type', null, 't');
        $qb->andWhere('t.id= :type:', ['type' => $type_id]);
        $qb->andWhere('p.date <= NOW()');
        $qb->orderBy('p.date DESC');
        $qb->limit($limit);

        $entries = $qb->getQuery()->execute();

        $this->widgetPartial('widget/last-news', ['entries' => $entries]);
    }

    public function popularArticles($type = null, $cat = null, $limit = 3) {
        //    $type_id = \Publication\Model\Type::getCachedBySlug($type);
        //           LEFT JOIN publication_type t
        //   ON t.id = p.type_id
        $query = "SELECT * FROM Publication\Model\Publication as p
WHERE p.date <= NOW()
    AND p.status = 'publish'";

        if (!empty($type)) {
            $query .= " AND p.type_id='{$type}'";
        }
        if (!empty($cat)) {
            $query .= " AND p.category_id IN
    (
    SELECT c.id FROM Tree\Model\Category AS c
    WHERE c.id='{$cat}' or c.parent_id ='{$cat}'"
                    . ")";
        }
        $query .= " ORDER BY p.counter DESC LIMIT $limit";

        $entries = $this->modelsManager->executeQuery($query);

        /* $qb = $this->modelsManager->createBuilder();
          $qb->addFrom('Publication\Model\Publication', 'p');
          $qb->leftJoin('Publication\Model\TreeCategory', null, 't');
          $qb->andWhere('t.slug = :cat:', ['cat' => $cat]);
          $qb->andWhere('p.date <= NOW()');
          $qb->andWhere("p.status = 'publish'");
          $qb->orderBy('p.counter DESC');
          $qb->limit($limit); */

        // $entries = $qb->getQuery()->execute();

        $this->widgetPartial('widget/popular-articles', ['entries' => $entries]);
    }

    public function similarArticles($current_id, $cat = null, $limit = 3) {
        $query = "SELECT * FROM Publication\Model\Publication as p
WHERE p.date <= NOW()
    AND p.status = 'publish' AND p.id <> '{$current_id}'";

        if (!empty($cat)) {
            $query .= " AND p.category_id IN
    (
    SELECT c.id FROM Tree\Model\Category AS c
    WHERE c.id='{$cat}' or c.parent_id ='{$cat}'"
                    . ")";
        }
        $query .= " ORDER BY RAND() DESC LIMIT $limit";

        $entries = $this->modelsManager->executeQuery($query);

        $this->widgetPartial('widget/similar-articles', ['entries' => $entries]);
    }

}
