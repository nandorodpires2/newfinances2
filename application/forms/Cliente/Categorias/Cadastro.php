<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cadastro
 *
 * @author Fernando
 */
class Form_Cliente_Categorias_Cadastro extends Zend_Form {
    
    public function init() {
        
        $this->setAttrib('id', "formCategoriasCadastro");
        
        // descricao_categoria
        $this->addElement('text', 'descricao_categoria', array(
            'label' => 'Categoria',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // submit
        $this->addElement('submit', 'submit', array(
            'label' => 'Salvar',
            "class" => "btn btn-submit navbar-right"
        ));
        
        //id_usuario
        $this->addElement('hidden', 'id_usuario', array('value' => Zend_Auth::getInstance()->getIdentity()->id_usuario));
        
    }
    
}
