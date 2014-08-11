<?php

class Cliente_IndexController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
     
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        $session = Zend_Registry::get('session');
        
        $modelMovimentacao = new Model_Movimentacao();
        
        /**
         * busca as proximas receitas
         */
        $receitas = $modelMovimentacao->getProximasReceitas($id_usuario);
        $this->view->receitas = $receitas;
        
        /**
         * buscas as proximas despesas
         */
        $despesas = $modelMovimentacao->getProximasDespesas($id_usuario);
        $this->view->despesas = $despesas;
        
    }

}

