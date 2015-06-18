<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author Fernando Rodrigues
 */
class Admin_LogController extends Zend_Controller_Action {
    
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
        
        // busca os logs
        $modelLog = new Model_Log();
        $logs = $modelLog->getLogs();
        $this->view->logs = $logs;
        
    }
    
}
