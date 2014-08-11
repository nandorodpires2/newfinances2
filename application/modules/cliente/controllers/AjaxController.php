<?php

class Cliente_AjaxController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
    }

    public function indexAction() {
        
    }
    
    public function movimentacoesAction() {
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
                                
        /**
         * lancamentos de hoje
         */
        $conta = $this->_getParam("id_conta", null);
        $data = $this->_getParam("data_movimentacao", date('Y-m-d'));        
        
        $modelVwMovimentacao = new Model_VwMovimentacao();
        $movimentacoes = $modelVwMovimentacao->getMovimentacoesData($data, $id_usuario, $conta);   
        
        $this->view->movimentacoes = $movimentacoes;
        
        /**
         * total receitas e despesas
         */
        $totalReceita = 0;
        $totalDespesa = 0;
        foreach ($movimentacoes as $movimentacao) {
            if ($movimentacao->realizado) {
                if ($movimentacao->id_tipo_movimentacao == 1) {
                    $totalReceita += $movimentacao->valor_movimentacao;
                } elseif ($movimentacao->id_tipo_movimentacao == 2) {
                    $totalDespesa += $movimentacao->valor_movimentacao;
                }
            }
        }        
        $this->view->totalReceita = $totalReceita;
        $this->view->totalDespesa = $totalDespesa;
        $this->view->saldo = $totalReceita + $totalDespesa;
        
    }
    
    /**
     * GRAFICOS
     */
    public function graficoReceitasDespesasAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        $ano = date('Y');
        
        $modelRelatorios = new Model_Relatorios();
        $relatorios = $modelRelatorios->getTotalValoresMes($id_usuario);
        
        $jsonData = array();
        
        foreach ($relatorios as $key => $relatorio) {
            if ($relatorio->id_tipo_movimentacao == 1) {
                $jsonData['receita']['data'][] = $relatorio->total;
            } else {
                $jsonData['despesa']['data'][] = $relatorio->total * -1;
            }
        }
        
        echo json_encode($jsonData);
        
    }
    
    public function graficoCategoriasAction () {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        $jsonData = array();
        echo json_encode($jsonData);
    }
    
    public function graficoOrcamentoAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        $jsonData = array();
        echo json_encode($jsonData);
    }

}

