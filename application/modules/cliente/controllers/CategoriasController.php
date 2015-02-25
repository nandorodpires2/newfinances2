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
        
    }
    
    public function indexAction() {
     
        // busca as categorias do usuario
        $modelCategoria = new Model_Categoria();
        $categorias = $modelCategoria->getCategoriasUsuario();
        $this->view->categorias = $categorias;
        
    }
    
}
