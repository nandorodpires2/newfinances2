<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function denyAction() {
        
        $module = $this->_getParam("module");
        
        // caso o bloqueio de acesso seja do tipo 1 
        // e pq e o gestor do sistema e nao tem permissao para ver
        // caso 2 e pq o plano nao contempla esta visualizacao
        // envia uma msg especifica para o usurio        
        $this->view->typeDeny = $module;
        
        
    }
    
}

