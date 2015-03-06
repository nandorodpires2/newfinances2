<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriasController
 *
 * @author Fernando Rodrigues
 */
class Cliente_CategoriasController extends Zend_Controller_Action {
    
    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }
    
    public function indexAction() {
     
        // busca as categorias do usuario
        $modelCategoria = new Model_Categoria();
        $categorias = $modelCategoria->getCategoriasUsuario();
        $this->view->categorias = $categorias;
        
    }
    
    /**
     * Nova categoria
     */
    public function novaCategoriaAction() {
        
        $formCategoriasCadastro = new Form_Cliente_Categorias_Cadastro();
        $this->view->formCategoriasCadastro = $formCategoriasCadastro;
        
        if ($this->_request->isPost()){
            $dadosCategoria = $this->_request->getPost();
            if ($formCategoriasCadastro->isValid($dadosCategoria)) {
                $dadosCategoria = $formCategoriasCadastro->getValues();
                
                $modelCategoria = new Model_Categoria();
                
                if ($this->ifExist($dadosCategoria['descricao_categoria'])) {                
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-warning',
                        'message' => 'Categoria já cadastrada!'
                    ));
                    $this->_redirect("cliente/categorias/nova-categoria");
                } 
                
                try {
                    $modelCategoria->insert($dadosCategoria);
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-success',
                        'message' => 'Categoria Cadastrada com sucesso!'
                    ));                    

                } catch (Exception $ex) {
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'alert alert-danger',
                        'message' => 'Houve um erro ao cadastrar a categoria. Favor tentar mais tarde!'
                    ));
                }
                $this->_redirect("cliente/categorias/index");
                
            }
        }
    
    }
    
    /**
     * 
     */
    public function editarAction() {
        
        $id_categoria = $this->_getParam("id_categoria");
        
        // busca dados da categoria
        $modelCategoria = new Model_Categoria();
        
        
    }
    
    /**
     * 
     */
    public function excluirAction() {
        
    }

    /**
     * Verifica se ja existe o registro no banco
     * @param type $name
     */
    protected function ifExist($name) {
          
        $modelCategoria = new Model_Categoria();
        $where = "descricao_categoria = '" . $name . "' and id_usuario = " . Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $categoria = $modelCategoria->fetchRow($where);
        if ($categoria) {
            return true;
        }
        return false;
        
    }
    
}
