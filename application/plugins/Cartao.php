<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cartao
 *
 * @author Fernando
 */
class Plugin_Cartao extends Zend_Controller_Plugin_Abstract {
    
    public function atualizaFatura($id_movimentacao) {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelVwLancamentoCartao = new Model_VwLancamentoCartao();
        $movimentacao = $modelVwLancamentoCartao->fetchRow("id_movimentacao = {$id_movimentacao}");                
        $modelFaturaCartao = new Model_FaturaCartao();
        
        if ($modelFaturaCartao->isVencimentoFaturaTabela($movimentacao->vencimento_fatura)) {
            // atualiza
            $totalFatura = $modelVwLancamentoCartao->getTotalFatura($movimentacao->id_cartao, $movimentacao->vencimento_fatura, $id_usuario);
            $modelFaturaCartao->update(array("saldo_atual" => $totalFatura->valor_fatura), "vencimento_fatura = '{$movimentacao->vencimento_fatura}'");
        } else {
            // insere            
            $dadosFatura = $modelVwLancamentoCartao->getFaturaByVencimento($movimentacao->vencimento_fatura, $id_usuario);
            $modelFaturaCartao->insert($dadosFatura->toArray());
        }        
        
    }
    
}
