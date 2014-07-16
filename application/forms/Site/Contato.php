<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contato
 *
 * @author Fernando Rodrigues
 */
class Form_Site_Contato extends Zend_Form {
    
    public function init() {
        
        $this->setAttribs(array(
            'id' => 'formContato',
            'role' => 'form'
        ));
        
        // nome
        $this->addElement('text', 'nome', array(
            'label' => 'Nome: ',
            'class' => 'form-control'
        ));
        
        // email
        $this->addElement('text', 'email', array(
            'label' => 'E-mail: ',
            'class' => 'form-control'
        ));
        
        // assunto
        $this->addElement('text', 'assunto', array(
            'label' => 'Assunto: ',
            'class' => 'form-control'
        ));
        
        // texto
        $this->addElement('textarea', 'texto', array(
            'label' => 'Mensagem',            
            'rows' => 10,
            'cols' => 80,
            'class' => 'form-control'
        ));
        
        // submit
        $this->addElement('submit', 'submit', array(
            'label' => 'Enviar',
            'class' => 'btn btn-submit navbar-right'
        ));
    }
    
}
