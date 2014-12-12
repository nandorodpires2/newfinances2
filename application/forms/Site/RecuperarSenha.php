<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecuperarSenha
 *
 * @author Fernando Rodrigues
 */
class Form_Site_RecuperarSenha extends Zend_Form {
    
    public function init() {
        
        // email
        $this->addElement('text', 'email', array(
            'label' => 'Digite seu e-mail',
            'required' => true,
            'class' => 'form-control'
        ));
        
        //submit
        $this->addElement('submit', 'submit', array(
            'label' => 'Enviar',
            'class' => 'btn btn-submit navbar-right'
        ));
        
    }
    
}
