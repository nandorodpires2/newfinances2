<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Relatorios
 *
 * @author Realter
 */
class Model_Relatorios extends Zend_Db_Table {

    protected $_name = "movimentacao";    
    protected $_primary = "id_movimentacao";
    
    public function getTotalValoresMes($id_usuario) {
        
        $select = $this->select()
                ->from($this->_name, array(
                    'id_tipo_movimentacao',
                    'total' => 'sum(valor_movimentacao)'
                ))
                ->where('id_usuario = ?', $id_usuario)
                ->where('id_tipo_movimentacao in (1,2)')
                ->where('realizado = ?', 1)
                ->where('year(data_movimentacao) = year(now())')
                ->group('year(data_movimentacao)')
                ->group('month(data_movimentacao)')
                ->group('id_tipo_movimentacao')
                ->order('month(data_movimentacao)');
        
        return $this->fetchAll($select);
        
    }
    
}

