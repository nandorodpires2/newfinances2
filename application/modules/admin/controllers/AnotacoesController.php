<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnotacoesController
 *
 * @author Fernando Rodrigues
 */
class Admin_AnotacoesController extends Zend_Controller_Action {
    
    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }
    
    public function indexAction() {
        
        $modelAnotacao = new Model_Anotacao();
        
        $order = "status_anotacao asc";
        
        $anotacoes = $modelAnotacao->fetchAll(null, $order);
        $this->view->anotacoes = $anotacoes;
        
    }
    
    public function novaAnotacaoAction() {
        
        $formAnotacoes = new Form_Admin_Anotacoes_Anotacao();
        $this->view->formAnotacoes = $formAnotacoes;
        
        $modelAnotacao = new Model_Anotacao();
        
        if ($this->_request->isPost()) {
            $dadosAnotacao = $this->_request->getPost();
            if ($formAnotacoes->isValid($dadosAnotacao)) {
                $dadosAnotacao = $formAnotacoes->getValues();
                
                $dadosAnotacao['status_anotacao'] = '1 - Pendente';
                
                try {
                    $modelAnotacao->insert($dadosAnotacao);
                    
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-success text-success padding-10px margin-10px-0px',
                        'message' => "Anotação Cadastada com sucesso!"
                    ));
                    
                    $this->_redirect("admin/anotacoes");
                    
                } catch (Exception $ex) {
                    die('erro');
                }
                
            }
        }
        
    }
    
    public function atualizarStatusAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        
        if ($this->_request->isPost()) {
            $dadosStatus = $this->_request->getPost();
            
            $modelAnotacao = new Model_Anotacao();
            
            foreach ($dadosStatus['status_anotacao'] as $key => $value) {
                $where_status = "id_anotacao = " . (int)$dadosStatus['id_anotacao'][$key];
                
                $dadosUpdate['status_anotacao'] = $value;
                
                $modelAnotacao->update($dadosUpdate, $where_status);
            }
            
            $this->_helper->flashMessenger->addMessage(array(
                'class' => 'bg-success text-success padding-10px margin-10px-0px',
                'message' => "Status atualizados com sucesso!"
            ));

            $this->_redirect("admin/anotacoes");
            
        }
        
    }
    
}
