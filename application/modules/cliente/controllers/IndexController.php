<?php

class Cliente_IndexController extends Zend_Controller_Action {

    public function init() {
        
        $translate = Zend_Registry::get('Zend_Translate');
        $this->view->translate = $translate;
        
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
     
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        /**
         * verifica se o usuario possui alguma conta cadastrada
         */
        $modelConta = new Model_Conta();
        $contas = $modelConta->isConta($id_usuario);
                
        if (!$contas) {            
            $url_pendencias = SYSTEM_URL . "cliente/contas/nova-conta";
            $messages = array(
                array(
                    'type' => 'warning',
                    'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                    'message' => "Por favor cadastre uma conta! <a class='text-blue' href='{$url_pendencias}'> Cadastrar</a>"
                )
            );
            $this->view->messages = $messages;
        }
        
        $this->view->isConta = $contas;
        
        /**
         * verifica pendencias
         */        
        $modelMovimentacao = new Model_Movimentacao();
        $pendencias = $modelMovimentacao->getPendencias($id_usuario);
        $count = $pendencias->count();
        
        if ($count > 0) {
            $url_pendencias = SYSTEM_URL . "cliente/pendencias";
            $messages = array(
                array(
                    'type' => 'warning',
                    'class' => 'bg-warning text-warning padding-10px margin-10px-0px',
                    'message' => "Existem {$count} lançamentos pendentes não realizados! <a class='text-blue' href='{$url_pendencias}'> Ver lançamentos</a>"
                )
            );
            $this->view->messages = $messages;
        }
        
        $session = Zend_Registry::get('session');
        
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

