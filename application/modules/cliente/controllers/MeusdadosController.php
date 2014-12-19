<?php

class Cliente_MeusdadosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        // busca os dados do usuario
        $modelUsuario = new Model_Usuario();
        $usuario = $modelUsuario->getUsuario($id_usuario);
        $this->view->usuario = $usuario;
        
        $usuario->data_nascimento = View_Helper_Date::getDataView($usuario->data_nascimento);
        
        // form de usuario
        $formSiteCadastro = new Form_Site_Cadastro();
        $formSiteCadastro->removeElement('politica');
        $formSiteCadastro->cpf_usuario->setAttrib("readonly", true);
        $formSiteCadastro->email_usuario->setAttrib("readonly", true);
        $formSiteCadastro->populate($usuario->toArray());
        $this->view->formSiteCadastro = $formSiteCadastro;
        
        // busca o plano do usuario
        $modelUsuarioPlano = new Model_UsuarioPlano();
        $planoUsuario = $modelUsuarioPlano->getPlanoAtual($id_usuario);
        $this->view->planoUsuario = $planoUsuario;
        
        
    }


}

