<?php

namespace Application\Widget;

use Application\Widget\AbstractWidget;
use Menu\Item;

class ApplicationWidget extends AbstractWidget {

    public function buildMenu($name, $template) {
        $tree = [];
        $entries = \Treemenu\Model\Category::find(array(
                    "conditions" => "root = '{$name}' AND depth = '1'",
                    "order" => "left_key",
        ));
        $i = 0;
        foreach ($entries as $entry) {
            $data = json_decode($entry->data);
            $url = $this->getUrlByData($data);

            $tree[$i]['entry'] = $this->getMenuObject($url, $entry, $data);
            //  $is_auto = ($entry->auto == 1 and $tree[$i]['entry']->typ == 'category');

            $subentries = \Treemenu\Model\Category::find(array(
                        "conditions" => "depth = '2' AND root = '{$name}' AND parent_id = '{$entry->getId()}'",
                        "order" => "left_key",
                        "limit" => 10,
            ));
            if (!empty($subentries)) {

                foreach ($subentries as $subentry) {
                    $suburl = "";
                    $data = json_decode($subentry->data);

                    if (empty($url)) {
                        $suburl = $this->getUrlByData($data);
                    } else {
                        $suburl = $this->getUrlByData($data);
                        if (!empty($suburl))
                            $suburl = $url . "/" . $suburl;
                    }
                    $obj = $this->getMenuObject($suburl, $subentry, $data);
                    $is_auto = ($subentry->auto == 1 and $obj->typ == 'category');
                    if ($is_auto) {

                        $subchilds = \Tree\Model\Category::find(array(
                                    "conditions" => "depth = '3' AND parent_id = '{$obj->item_id}'",
                                    "order" => "left_key",
                                    "limit" => 8,
                        ));
                    } else {

                        $subchilds = \Treemenu\Model\Category::find(array(
                                    "conditions" => "depth = '3' AND root = '{$name}' AND parent_id = '{$subentry->getId()}'",
                                    "order" => "left_key",
                                    "limit" => 8,
                        ));
                    }

                    $childs = array();
                    foreach ($subchilds as $child) {
                        if ($is_auto) {
                            $child_url = $child->getSlug();
                        } else {
                            $child_data = json_decode($child->data);
                            $child_url = $this->getUrlByData($child_data);
                        }

                        if (!empty($child_url))
                            $child_url = $suburl . "/" . $child_url;


                        $childs[] = $this->getMenuObject($child_url, $child, null, $is_auto);
                    }

                    $tree[$i]['subentries'][] = array("entry" => $obj, "childs" => $childs);
                }
            } else {
                $tree[$i]['subentries'] = array();
            }
            $i++;
        }
        $this->widgetPartial($template, ['entries' => $tree]);
    }

    public function sidebarMenu($cat_id, $name, $template) {
        $tree = [];
       

        $entries = \Treemenu\Model\Category::find(array(
                    "conditions" => "root = '{$name}' AND depth = '1'",
                    "order" => "left_key",
        ));

        $id = 0;
        $url = "";

        foreach ($entries as $entry) {

            $data = json_decode($entry->data);

            if ($data->item_id == $cat_id && $data->type == 'category') {
                $url = $this->getUrlByData($data);
                $id = $entry->getId();
            }
        }

        $subentries = \Treemenu\Model\Category::find(array(
                    "conditions" => "depth = '2' AND root = '{$name}' AND parent_id = '{$id}'",
                    "order" => "left_key",
        ));

        if (!empty($subentries)) {


            foreach ($subentries as $subentry) {
                $suburl = "";
                $data = json_decode($subentry->data);
                if (empty($url)) {
                    $suburl = $this->getUrlByData($data);
                } else {
                    $suburl = $this->getUrlByData($data);
                    if (!empty($suburl))
                        $suburl = $url . "/" . $suburl;
                }
                $obj = $this->getMenuObject($suburl, $subentry, $data);

                $is_auto = ($subentry->auto == 1 and $obj->typ == 'category');
                if ($is_auto) {

                    $subchilds = \Tree\Model\Category::find(array(
                                "conditions" => "depth = '3' AND parent_id = '{$obj->item_id}'",
                                "order" => "left_key",
                    ));
                } else {

                    $subchilds = \Treemenu\Model\Category::find(array(
                                "conditions" => "depth = '3' AND root = '{$name}' AND parent_id = '{$subentry->getId()}'",
                                "order" => "left_key",
                    ));
                }
                $childs = array();
                foreach ($subchilds as $child) {
                    if ($is_auto) {
                        $child_url = $child->getSlug();
                    } else {
                        $child_data = json_decode($child->data);
                        $child_url = $this->getUrlByData($child_data);
                    }

                    if (!empty($child_url))
                        $child_url = $suburl . "/" . $child_url;
                    $childs[] = $this->getMenuObject($child_url, $child, null, $is_auto);
                }

                $tree[] = array("entry" => $obj, "childs" => $childs);
            }
        } else {
            $tree = array();
        }

        $this->widgetPartial($template, ['entries' => $tree]);
    }

    private function getMenuObject($url, $entry, $data = null, $auto = 0) {
        $obj = new \stdClass();
        if (empty($url)) {
            $obj->url = "javascript:void(0)";
        } else
            $obj->url = $this->config->base_path . $url;

        if ($auto) {
            $obj->title = $entry->getTitle();
            $obj->newwindow = 0;
            $obj->custom = 0;
            $obj->auto = 0;
            $obj->status = 1;
        } else {
            $obj->title = $entry->getTitle();
            $obj->newwindow = $entry->getNewwindow();
            $obj->custom = $entry->getCustom();
            $obj->auto = $entry->getAuto();
            $obj->status = $entry->getStatus();
        }

        if ($data) {
            $obj->type = $data->item_id;
            $obj->item_id = $data->item_id;
            $obj->typ = $data->type;
        }
        return $obj;
    }

    private function getUrlByData($data) {
        if ($data->type == 'category') {
            $item = \Tree\Model\Category::findFirst("id='{$data->item_id}'");
            if($item) {
                if(empty($item->getParentId()) and $item->getDepth() == 1)
                    return $item->getRoot() . "/" . $item->getSlug();
                else
                    return $item->getSlug();
            } else {
                return null;
            }
        } else if ($data->type == 'page') {
            $item = \Page\Model\Page::findFirst("id='{$data->item_id}'");
            return $item->getSlug() . ".html";
        } else if ($data->type == 'type') {
            $item = \Publication\Model\Type::findFirst("id='{$data->item_id}'");
            if($item)
              return $item->getSlug();
            else
                return null;
        } else {
            return null;
        }
    }

}
