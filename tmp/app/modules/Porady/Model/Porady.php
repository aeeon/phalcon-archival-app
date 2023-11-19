<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Porady\Model;
use Application\Mvc\Model\Model;

class Porady extends Model {

    private $name;
    private $email;
    private $text;
    private $phone;
    private $zgoda2;
    private $zgoda1;
    
    public static function getProvinceList() {
        $data = array(
            0 => 'dowolne',
            1 => 'dolnośląskie',
            2 => 'kujawsko-pomorskie',
            3 => 'lubelskie',
            4 => 'lubuskie',
            5 => 'łódzkie',
            6 => 'małopolskie',
            7 => 'mazowieckie',
            8 => 'opolskie',
            9 => 'podkarpackie',
            10 => 'podlaskie',
            11 => 'pomorskie',
            12 => 'śląskie',
            13 => 'świętokrzyskie',
            14 => 'warmińsko-mazurskie',
            15 => 'wielkopolskie',
            16 => 'zachodniopomorskie',
            17 => 'zagranica'
        );
        return $data;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getText() {
        return $this->text;
    }

    public function getPhone() {
        return $this->phone;
    }


    public function getZgoda1() {
        return $this->zgoda1;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }



    public function setZgoda1($zgoda1) {
        $this->zgoda1 = $zgoda1;
    }
    public function getZgoda2() {
        return $this->zgoda2;
    }

    public function setZgoda2($zgoda2) {
        $this->zgoda2 = $zgoda2;
    }



}
