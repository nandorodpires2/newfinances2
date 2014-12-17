<?php

class Admin_PlanoController extends Zend_Controller_Action
{

    public function init()
    {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction()
    {
        
        // busca os planos do sistema
        $modelPlano = new Model_Plano();
        $planos = $modelPlano->fetchAll("ativo_plano = 1");
        $this->view->planos = $planos;
        
    }

    public function novoPlanoAction()
    {
        // action body
    }

    public function editarPlanoAction()
    {
        // action body
    }

    public function excluirPlanoAction()
    {
        // action body
    }

    public function permissoesPlanoAction()
    {
        
        $id_plano = $this->_getParam('id_plano');
        
        // busca dados do plano
        $modelPlano = new Model_Plano();
        $plano = $modelPlano->getPlanoById($id_plano);
        $this->view->plano = $plano;
        
        // busca as funcionalidades do plano
        $modelPlanoFuncionalidade = new Model_PlanoFuncionalidade();
        $planoFuncionalidades = $modelPlanoFuncionalidade->getFuncionalidadesPlano($plano->id_plano);
        
        $populate = array();
        foreach ($planoFuncionalidades as $value) {            
            $populate[$value->module][] = $value->id_funcionalidade;            
        }        
        // form de permissoes
        $formPlanoFuncionalidadeCadastro = new Form_Admin_Plano_CadastroFuncionalidade();        
        $formPlanoFuncionalidadeCadastro->populate($populate);
        $formPlanoFuncionalidadeCadastro->id_plano->setValue($id_plano);
        $this->view->formPlanoFuncionalidadeCadastro = $formPlanoFuncionalidadeCadastro;
        
        if ($this->_request->isPost()) {
            $dadosPlanoFuncionalidade = $this->_request->getPost();
            if ($formPlanoFuncionalidadeCadastro->isValid($dadosPlanoFuncionalidade)) {
                $dadosPlanoFuncionalidade = $formPlanoFuncionalidadeCadastro->getValues();
                $dadosInsert = array();
                
                // apaga as funcionalidades do plano                
                try {
                    $modelPlanoFuncionalidade->delete("id_plano = {$id_plano}");
                    foreach ($dadosPlanoFuncionalidade as $key => $values) {
                        if ($values && $key != 'id_plano') {                        
                            foreach ($values as $value) {
                                $dadosInsert['id_plano'] = $id_plano;
                                $dadosInsert['id_funcionalidade'] = $value;
                                $modelPlanoFuncionalidade->insert($dadosInsert);
                            }                                     
                        }
                    }           
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-success',
                        'message' => 'Regras de acesso cadastrada com sucesso!!'
                    ));
                    $this->_redirect("admin/plano");
                } catch (Exception $ex) {
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-danger',
                        'message' => 'Houve um erro ao cadastrar as regras de acesso!!'
                    ));
                    $this->_redirect("admin/plano/permissoes-plano/id_plano/{$id_plano}");
                }
                
            }
        }
        
    }


}









