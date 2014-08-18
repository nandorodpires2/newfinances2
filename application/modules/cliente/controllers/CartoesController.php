<?php

class Cliente_CartoesController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelCartao = new Model_Cartao();
        $cartoes = $modelCartao->getCartoesUsuario($id_usuario);
        $this->view->cartoes = $cartoes;
        
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

    public function editarCartaoAction()
    {
        // action body
    }

    public function excluirCartaoAction()
    {
        // action body
    }


}







