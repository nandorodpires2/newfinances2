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
class Form_Admin_Plano_CadastroFuncionalidade extends Zend_Form {
    
    public function init() {
        
        // busca os modulos
        $modelFuncionalidade = new Model_Funcionalidade();
        $modulos = $modelFuncionalidade->getModulesPlano();
                
        foreach ($modulos as $modulo) {
            
            // busca as funcionalidade
            
            $this->addElement('multicheckbox', 'id_funcionalidade_' . $modulo->module, array(
                'label' => $modulo->module,
                'registerInArray' => true,
                'multioptions' => array(
                    3 => ' Lançar Receita',
                    4 => ' Lançar Despesa'
                )
            ));
        }
        
        
        
    }
    
}
