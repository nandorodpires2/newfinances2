<?php

class Cliente_ChamadosController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelChamados = new Model_Chamado();
        // abertos
        $chamados_abertos = $modelChamados->getChamadosUsuario($id_usuario, 'Aberto');
        $this->view->chamados_abertos = $chamados_abertos;
        // fechados
        $chamados_finalizados = $modelChamados->getChamadosUsuario($id_usuario, 'Fechado');
        $this->view->chamados_finalizados = $chamados_finalizados;
        
    }

}

