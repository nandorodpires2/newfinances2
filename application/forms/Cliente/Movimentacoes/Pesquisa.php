<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pesquisa
 *
 * @author Fernando
 */
class Form_Cliente_Movimentacoes_Pesquisa extends Zend_Form {
    
    public function init() {
        
        $formDefault = new Form_Default();
        
        $this->addAttribs(array(
            'class' => 'form-inline'
        ));
        
        $this->addElement('text', 'palavra_chave', array(
            'label' => 'Palavra Chave',
            'class' => 'form-control'
        ));
        
        $this->addElement('select', 'id_categoria', array(
            'label' => 'Categoria',
            'class' => 'form-control',
            'multioptions' => $formDefault->getCategorias()
        ));
        
        $this->addElement('text', 'data_inicial', array(
            'label' => 'Data Inicial',
            'class' => 'form-control'            
        ));
        
        $this->addElement('text', 'data_final', array(
            'label' => 'Data Final',
            'class' => 'form-control'            
        ));
        
        $this->addElement('submit', 'submit', array(
            'label' => 'Pesquisar',
            'class' => 'btn btn-success'
        ));
        
    }
    
}
