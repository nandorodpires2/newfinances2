<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Fernando Rodrigues
 */
class Model_Usuario extends Zend_Db_Table_Abstract {
    
    protected $_name = "usuario";
    
    protected $_primary = "id_usuario";
    
}
