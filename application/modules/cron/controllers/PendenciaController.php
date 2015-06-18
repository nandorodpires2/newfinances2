<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pendencia
 *
 * @author Fernando Rodrigues
 */
class Cron_PendenciaController extends Zend_Controller_Action {
    
    public function init() {
        parent::init();
    }
    
    public function indexAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        
        // busca as pendencias
        $modelCron = new Model_Cron();
        $pendencias = $modelCron->getCountPendencias();
        
        foreach ($pendencias as $pendencia) {
            // envia um e-mail de resposta para o visitante
            $html = new Zend_View();
            $html->setScriptPath(EMAILS_CRON . '/pendencia/');

            // assign values        
            $html->assign('pendencia', $pendencia);

            // render view
            $bodyText = $html->render('pendencias.phtml');

            // envia os emails para os usuarios
            $mail = new Zend_Mail('utf-8');
            $mail->setBodyHtml($bodyText);
            $mail->setFrom('noreply@newfinances.com.br', 'NewFinances - Controle Financeiro');
            $mail->addTo($pendencia->email_usuario);                          
            $mail->setSubject("Pendências");

            $mail->send(Zend_Registry::get('mail_transport'));
        }
        
    }
    
}
