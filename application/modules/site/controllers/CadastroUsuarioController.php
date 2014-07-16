<?php

class CadastroUsuarioController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
        $formSiteCadastro = new Form_Site_Cadastro();
        $this->view->formSiteCadastro = $formSiteCadastro;
        
    }

}

