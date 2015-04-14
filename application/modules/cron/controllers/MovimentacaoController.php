<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MovimentacaoController
 *
 * @author Fernando Rodrigues
 */
class Cron_MovimentacaoController extends Zend_Controller_Action {
    
    public function init()
    {
        
    }

    public function indexAction()
    {
        
        $this->_helper->viewRenderer->setNoRender(true);
        
        // data de dois dias a frente
        $zendDate = new Zend_Date();
        $zendDate->addDay(2);
        $date = $zendDate->get("YYYY-MM-dd");
                
        // busca os lancamentos
        $modelMovimentacao = new Model_Movimentacao();
        $lancamentos = $modelMovimentacao->getLancamentosCron($date);        
        
        foreach ($lancamentos as $lancamento) {
            
            // envia um e-mail de resposta para o visitante
            $html = new Zend_View();
            $html->setScriptPath(EMAILS_CRON . '/movimentacao/');

            // assign values        
            $html->assign('lancamento', $lancamento);

            // render view
            $bodyText = $html->render('lembrete.phtml');

            // envia os emails para os usuarios
            $mail = new Zend_Mail('utf-8');
            $mail->setBodyHtml($bodyText);
            $mail->setFrom('noreply@newfinances.com.br', 'NewFinances - Controle Financeiro');
            $mail->addTo($lancamento->email_usuario);                          
            $mail->setSubject("Lembrete");

            $mail->send(Zend_Registry::get('mail_transport'));
            
        }
        
        
    }
    
}
