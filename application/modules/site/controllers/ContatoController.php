<?php

class ContatoController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
        $formSiteContato = new Form_Site_Contato();        
        $this->view->formSiteContato = $formSiteContato;
        
    }


}

