<?php

class Cliente_ContasController extends Zend_Controller_Action
{

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction()
    {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        $modelConta = new Model_Conta();
        $contas = $modelConta->getContasUsuario($id_usuario);
        $this->view->contas = $contas;
        
    }

    public function novaContaAction()
    {
        
        $formClienteConta = new Form_Cliente_Contas_Conta();
        $this->view->formClienteConta = $formClienteConta;
        
        $modelConta = new Model_Conta();
        
        if ($this->_request->isPost()) {            
            $dadosConta = $this->_request->getPost();
            if ($formClienteConta->isValid($dadosConta)) {
                $dadosConta = $formClienteConta->getValues();
                                
                if ($dadosConta['id_banco'] == '') {
                    $dadosConta['id_banco'] = null;
                }
                
                $dadosConta['ativo_conta'] = 1;
                $dadosConta['data_inclusao'] = Controller_Helper_Date::getDatetimeNowDb();
                $dadosConta['saldo_inicial'] = View_Helper_Currency::setCurrencyDb($dadosConta['saldo_inicial'], 'positivo');
                
                try {                
                    $modelConta->insert($dadosConta);   
                    
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-success text-success padding-10px margin-10px-0px',
                        'message' => "Conta Cadastada com sucesso!"
                    ));
                    
                    $this->_redirect("cliente/cartoes");
                    
                } catch (Zend_Exception $erro) {
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                        'message' => "Houve um erro ao cadastrar sua conta!"
                    ));
                    
                    $this->_redirect("cliente/contas");
                }   
                
            }
        }
        
    }

    public function editarContaAction()
    {
        // action body
    }

    public function excluirContaAction()
    {
        // action body
    }


}







