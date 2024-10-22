<?php

class homeController extends Controller {

    public function index() {
        $params['title'] = "Home - My Sneakers";
        $this -> render ('home/home',$params,'main');
    }

    public function contact() {
        $params['title'] = "Contact - My Sneakers";
        $this -> render ('home/contact',$params,'main');
    }

    public function sobreNosotros() {
        $params['title'] = "Sobre Nosaltres - My Sneakers";
        $this -> render ('home/quisom',$params,'main');
    }
}