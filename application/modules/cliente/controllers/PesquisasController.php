<?php

class Cliente_PesquisasController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function avancadaAction() {
        
        $formMovimentacoesPesquisa = new Form_Cliente_Movimentacoes_Pesquisa();
        $this->view->formPesquisa = $formMovimentacoesPesquisa;
        
    }

}

