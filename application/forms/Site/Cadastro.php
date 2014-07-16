<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cadastro
 *
 * @author Fernando Rodrigues
 */
class Form_Site_Cadastro extends Zend_Form {
    
    public function init() {
        
        $this->setAttribs(array(
            'id' => 'formSiteCadastro',
            'role' => 'form'
        ));
        
        // nome_completo
        $this->addElement('text', 'nome_completo', array(
            'label' => 'Nome Completo: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // cidade
        $this->addElement('text', 'cidade', array(
            'label' => 'Cidade: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // cpf_usuario
        $this->addElement('text', 'cpf_usuario', array(
            'label' => 'CPF: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // data_nascimento
        $this->addElement('text', 'data_nascimento', array(
            'label' => 'Data Nascimento: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // id_estado
        
        // email_usuario
        $this->addElement('text', 'email_usuario', array(
            'label' => 'E-mail: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // senha_usuario
        $this->addElement('password', 'senha_usuario', array(
            'label' => 'Senha: ',
            'required' => true,
            'class' => 'form-control'
        ));
        
        // politica
        $this->addElement('checkbox', 'politica', array(            
            'required' => true,
            'value' => '1',
            'class' => 'checkbox',
            'decorators' => array(
                'ViewHelper',
                'Description',
                'Errors',                
                array(
                    'Label', array(
                        'tag' => 'span',
                        'class' => 'control-label margin-top-10px'
                    )
                ),
                array(
                    'HtmlTag', array(
                        'tag' => 'span',
                        'class' => 'checkbox'
                    )
                ),
            ),
            'label' => "Li e concordo com a Política de Privacidade e o Termo de Uso"
        ));
        
        // submit
        $this->addElement('submit', 'submit', array(
            'label' => 'Enviar',
            'class' => 'btn btn-submit navbar-right'
        ));
        
    }
    
}
