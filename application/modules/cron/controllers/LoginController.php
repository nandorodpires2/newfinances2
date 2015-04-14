<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author Fernando Rodrigues
 */
class Cron_LoginController extends Zend_Controller_Action {
    
    const DAYS_BEFORE_CHECK = 30;
    
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        
        $modelCron = new Model_Cron();
        $lastLogins = $modelCron->getLastLoginUsuarios();
        
        foreach ($lastLogins as $dados) {
            
            $zendDate = new Zend_Date($dados->ultimo_login);
            $zendDate->addDay(self::DAYS_BEFORE_CHECK);
            
            $date_now = date("Y-m-d H:i:s");
            
            if ($zendDate->isEarlier($date_now)) {
                
                // envia um e-mail de resposta para o visitante
                $html = new Zend_View();
                $html->setScriptPath(EMAILS_CRON . '/login/');

                // assign values        
                $html->assign('dados', $dados);

                // render view
                $bodyText = $html->render('ultimo-login.phtml');

                // envia os emails para os usuarios
                $mail = new Zend_Mail('utf-8');
                $mail->setBodyHtml($bodyText);
                $mail->setFrom('noreply@newfinances.com.br', 'NewFinances - Controle Financeiro');
                $mail->addTo($dados->email_usuario);                          
                $mail->setSubject("Aviso Importante");

                $mail->send(Zend_Registry::get('mail_transport'));
                
            }
            
        }
        
    }
    
}
