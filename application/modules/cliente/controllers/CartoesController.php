<?php

class Cliente_CartoesController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelCartao = new Model_Cartao();
        // ativos
        $cartoes_ativos = $modelCartao->getCartoesUsuario($id_usuario, 1);
        $this->view->cartoes_ativos = $cartoes_ativos;
        // inativos
        $cartoes_inativos = $modelCartao->getCartoesUsuario($id_usuario, 0);
        $this->view->cartoes_inativos = $cartoes_inativos;
        
    }

    public function novoCartaoAction() {
        
        $formClienteCartao = new Form_Cliente_Cartoes_Cartao();
        $this->view->formClienteCartao = $formClienteCartao;
        
        $modelCartao = new Model_Cartao();
        
        if ($this->_request->isPost()) {
            $dadosCartao = $this->_request->getPost();
            if ($formClienteCartao->isValid($dadosCartao)) {
                $dadosCartao = $formClienteCartao->getValues();
                               
                $dadosCartao['ativo_cartao'] = 1;
                $dadosCartao['limite_cartao'] = View_Helper_Currency::setCurrencyDb($dadosCartao['limite_cartao'], 'positivo');
                
                try {
                    $modelCartao->insert($dadosCartao);
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-success text-success padding-10px margin-10px-0px',
                        'message' => "Cartão Cadastado com sucesso!"
                    ));
                    
                } catch (Zend_Db_Exception $db_exception) {
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                        'message' => "Houve um erro ao cadastrar o cartão!"
                    ));
                    
                }
                $this->_redirect("cliente/cartoes");
            }
        }
    }

    public function editarCartaoAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $id_cartao = $this->_getParam('id_cartao');
        
        $modelCartao = new Model_Cartao();
        $cartao = $modelCartao->getCartaoById($id_cartao, $id_usuario);
        
        if (!$cartao) {            
            $this->_helper->flashMessenger->addMessage(array(
                'class' => 'bg-warning text-warning padding-10px margin-10px-0px',
                'message' => "Cartão não encontrado!"
            ));
            
            $this->_redirect("cliente/cartoes");
            
        }
        
        $cartao->limite_cartao = number_format($cartao->limite_cartao, 2, ',', '.');
        
        $formCartao = new Form_Cliente_Cartoes_Cartao();
        $formCartao->populate($cartao->toArray());
        $formCartao->submit->setLabel("Editar");
        $this->view->formCartao = $formCartao;
        
        if ($this->_request->isPost()) {
            $dadosUpdate = $this->_request->getPost();
            if ($formCartao->isValid($dadosUpdate)) {
                
                $dadosUpdate = $formCartao->getValues();
                
                $dadosUpdate['limite_cartao'] = View_Helper_Currency::setCurrencyDb($dadosUpdate['limite_cartao'], 'positivo');
                
                $where = "id_cartao = " . $id_cartao;                
                
                try {
                    
                    $modelCartao->update($dadosUpdate, $where);                    
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-success text-success padding-10px margin-10px-0px',
                        'message' => "Dados atualizados com sucesso!"
                    ));
                    
                } catch (Exception $ex) {
                    
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                        'message' => "Houve um erro ao atualizar os dados!"
                    ));
                    
                }
                
                $this->_redirect("cliente/cartoes");
                
            }
        }        
        
    }

    public function excluirCartaoAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $id_cartao = $this->_getParam('id_cartao');
        
        $modelCartao = new Model_Cartao();
        $cartao = $modelCartao->getCartaoById($id_cartao, $id_usuario);
        $this->view->cartao = $cartao;
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            if ($dados['btn-opt'] == 'Cancelar') {                
                $this->_helper->flashMessenger->addMessage(array(
                    'class' => 'bg-warning text-warning padding-10px margin-10px-0px',
                    'message' => 'Exclusão cancelada!'
                ));
                $this->_redirect("cliente/cartoes");
            } else {
                $dadosUpdate['ativo_cartao'] = 0;
                $whereUpdate = "id_cartao = " . $id_cartao;
                $modelCartao->update($dadosUpdate, $whereUpdate);
                
                $this->_helper->flashMessenger->addMessage(array(
                    'class' => 'bg-success text-success padding-10px margin-10px-0px',
                    'message' => 'Cartão excluído com sucesso!'
                ));
                $this->_redirect("cliente/cartoes");
                
            }
            
        }
        
    }
    
    public function reativarCartaoAction() {
     
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $id_cartao = $this->_getParam('id_cartao');
        
        $modelCartao = new Model_Cartao();
        $cartao = $modelCartao->getCartaoById($id_cartao, $id_usuario);
        
        if (!$cartao) {            
            $this->_helper->flashMessenger->addMessage(array(
                'class' => 'bg-warning text-warning padding-10px margin-10px-0px',
                'message' => "Cartão não encontrado!"
            ));
            
            $this->_redirect("cliente/cartoes");            
        }
        
        $dadosUpdate['ativo_cartao'] = 1;
        $where = "id_cartao = " . $id_cartao;
        
        try {
            $modelCartao->update($dadosUpdate, $where);
            $this->_helper->flashMessenger->addMessage(array(
                'class' => 'bg-success text-success padding-10px margin-10px-0px',
                'message' => 'Cartão reativado com sucesso!'
            ));
            $this->_redirect("cliente/cartoes");
        } catch (Exception $ex) {
            $this->_helper->flashMessenger->addMessage(array(
                'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                'message' => 'Houve um erro ao reativar o cartão!'
            ));
            $this->_redirect("cliente/cartoes");
        }
        
    }
    
    /**
     * lançamentos fatura
     */
    public function lancamentosAction() {
        
        $id_cartao = $this->_getParam("cartao");        
        $vencimento_fatura = $this->_getParam("fatura");        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelVwLancamentosCartao = new Model_VwLancamentoCartao();
        $lancamentos = $modelVwLancamentosCartao->getLancamentosFatura($id_cartao, $vencimento_fatura, $id_usuario);
        $this->view->lancamentos = $lancamentos;        
        
        $total_fatura = $modelVwLancamentosCartao->getTotalFatura($id_cartao, $vencimento_fatura, $id_usuario);
        $this->view->total_fatura = $total_fatura->valor_fatura;
        
    }

}







