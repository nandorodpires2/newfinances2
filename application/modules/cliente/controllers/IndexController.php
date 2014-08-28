<?php

class Cliente_IndexController extends Zend_Controller_Action {

    public function init() {
        
        $translate = Zend_Registry::get('Zend_Translate');
        $this->view->translate = $translate;
        
        $pluginMessage = new Plugin_Messages();
        $pluginMessage->isConta();
        $pluginMessage->isPendencias();
        
        $messages = $this->_helper->FlashMessenger->getMessages();        
        $this->view->messages = $messages;
        
    }

    public function indexAction() {
     
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $session = Zend_Registry::get('session');
        
        $modelMovimentacao = new Model_Movimentacao();
        
        /**
         * faturas dos cartoes de credito
         */        
        
        // busca os cartoes do usuario
        $modelCartao = new Model_Cartao();
        $cartoes = $modelCartao->getCartoesUsuario($id_usuario, 1);  
        $this->view->cartoes = $cartoes;
        //Zend_Debug::dump($cartoes);
        
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
        
        /**
         * saldo das contas
         */
       $modelConta = new Model_Conta();
       $saldos = $modelConta->getSaldoContas($id_usuario);       
       $this->view->saldos = $saldos;     
       
       $saldo_total = 0;
        foreach ($saldos as $saldo) {
            $saldo_total += $saldo->saldo;
        }
        
        $this->view->saldo_total = $saldo_total;
        
    }

}

