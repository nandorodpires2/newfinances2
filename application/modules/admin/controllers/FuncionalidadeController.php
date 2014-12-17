<?php

class Admin_FuncionalidadeController extends Zend_Controller_Action
{

    public function init()
    {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction()
    {
        
        // busca as funcionalidades
        $modelFuncionalidade = new Model_Funcionalidade();
        $funcionalidades = $modelFuncionalidade->getFuncionalidades();
        $this->view->funcionalidades = $funcionalidades;
        
        
    }

    public function editarFuncionalidadeAction()
    {
        // action body
    }

    public function excluirFuncionalidadeAction()
    {
        // action body
    }

    public function novaFuncionalidadeAction()
    {
        
        // form de nova funcionalidade
        $formAdminFuncionalidadeCadastro = new Form_Admin_Funcionalidade_Cadastro();
        $this->view->formAdminFuncionalidadeCadastro = $formAdminFuncionalidadeCadastro;
        
        if ($this->_request->isPost()) {
            $dadosFuncionalidade = $this->_request->getPost();
            if ($formAdminFuncionalidadeCadastro->isValid($dadosFuncionalidade)) {
                $dadosFuncionalidade = $formAdminFuncionalidadeCadastro->getValues();
                
                $modelFuncionalidade = new Model_Funcionalidade();
                
                try {
                    $modelFuncionalidade->insert($dadosFuncionalidade);
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-success',
                        'message' => 'Funcionalidade cadastrada com sucesso!!'
                    ));
                    $this->_redirect("admin/funcionalidade");
                } catch (Exception $ex) {
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-danger',
                        'message' => 'Houve um erro ao cadastrar funcionalidade!!'
                    ));
                    $this->_redirect("admin/funcionalidade");
                }
                
            }
        }
        
    }


}







