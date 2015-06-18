<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author rosousas
 */
class Plugin_Auth extends Zend_Controller_Plugin_Abstract {
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
                 
        $auth = Zend_Auth::getInstance();      
        
        if (($moduleName !== 'site' && $moduleName !== 'cron') && $actionName !== 'login') {               
            if (!$auth->hasIdentity()) {
                $request->setModuleName('site')
                        ->setControllerName('usuarios')
                        ->setActionName('login')
                        ->setDispatched();
            }
        }
        
    }
    
}


