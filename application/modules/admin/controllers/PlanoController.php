<?php

class Admin_PlanoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
        
        $id_plano = $this->getParam('id_plano');
        
        // busca dados do plano
        $modelPlano = new Model_Plano();
        $plano = $modelPlano->getPlanoById($id_plano);
        $this->view->plano = $plano;
        
        // form de permissoes
        $formPlanoFuncionalidadeCadastro = new Form_Admin_Plano_CadastroFuncionalidade();
        $this->view->formPlanoFuncionalidadeCadastro = $formPlanoFuncionalidadeCadastro;
        
    }


}









