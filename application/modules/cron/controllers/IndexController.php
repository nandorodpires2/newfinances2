<?php

class Cron_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
        // envia emails de teste        
        $html = new Zend_View();
        $html->setScriptPath(EMAILS_CRON . '/index/');

        // render view
        $bodyText = $html->render('teste.phtml');

        // envia os emails para os usuarios
        $mail = new Zend_Mail('utf-8');
        $mail->setBodyHtml($bodyText);
        $mail->setFrom('noreply@newfinances.com.br', 'NewFinances - Controle Financeiro');
        $mail->addTo("nandorodpires@gmail.com");                          
        $mail->setSubject("Teste");

        $mail->send(Zend_Registry::get('mail_transport'));
        
    }    
    
}

