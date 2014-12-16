<?php

class Admin_FuncionalidadeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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


}





