<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriasController
 *
 * @author Fernando
 */
class Admin_CategoriasController extends Zend_Controller_Action {
    
    public function init() {
        
    }
    
    public function indexAction() {
        
        $modelCategoria = new Model_Categoria();
        $categorias = $modelCategoria->getCategoriasSistema();
        $this->view->categorias = $categorias;
        
    }
    
    /**
     * 
     */
    public function novaCategoriaAction() {
        
        $modelCategoria = new Model_Categoria();
        
        $formCategoriaCadastro = new Form_Admin_Categoria_Cadastro();
        $this->view->formCategoriaCadastro = $formCategoriaCadastro;
        
        if ($this->_request->isPost()){
            $dadosCategoria = $this->_request->getPost();
            if ($formCategoriaCadastro->isValid($dadosCategoria)){
                $dadosCategoria = $formCategoriaCadastro->getValues();
                try {
                    $modelCategoria->insert($dadosCategoria);
                    $this->_redirect("admin/categorias");
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                
            }
        }
        
    }
    
}
