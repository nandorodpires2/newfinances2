<?php

class Cliente_AjaxController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
    }

    public function indexAction() {
        
    }
    
    public function movimentacoesAction() {
        
        $auth = Zend_Registry::get('auth')->getIdentity();
                        
        /**
         * lancamentos de hoje
         */
        $conta = $this->_getParam("id_conta", null);
        $data = $this->_getParam("data_movimentacao", date('Y-m-d'));        
        
        $modelVwMovimentacao = new Model_VwMovimentacao();
        $movimentacoes = $modelVwMovimentacao->getMovimentacoesData($data, $auth->id_usuario, $conta);   
        
        $this->view->movimentacoes = $movimentacoes;
        
    }

}

