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
        $data = $this->_getParam("data", Zend_Auth::getInstance()->getIdentity()->data);        
        
        $this->view->data_movimentacao = Controller_Helper_Date::getDateViewComplete($data);
        
        if ($data != Zend_Auth::getInstance()->getIdentity()->data) {
            Zend_Auth::getInstance()->getIdentity()->data = $data;
        }
                
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
        
        $jsonData = array(
            'dataCount' => 0
        );
        
        if ($relatorios->count() > 0) {
            $jsonData['receita']['data'][0] = 0;
            $jsonData['despesa']['data'][0] = 0;
            foreach ($relatorios as $key => $relatorio) {
                if ($relatorio->id_tipo_movimentacao == 1) {
                    $jsonData['receita']['data'][] = $relatorio->total;
                } else {
                    $jsonData['despesa']['data'][] = $relatorio->total * -1;
                }
            }
        }
        
        echo json_encode($jsonData);
        
    }
    
    public function graficoCategoriasAction () {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelCategoria = new Model_Categoria();
        $gastosCategoria = $modelCategoria->getGastosCategoriasMes($id_usuario);
        
        $jsonData = array(
            'dataCount' => 0
        );
        
        if ($gastosCategoria->count() > 0) {
            $jsonData['dataCount'] = $gastosCategoria->count();
            foreach ($gastosCategoria as $key => $gasto) {

                $jsonData['data'][$key]['name'] = $gasto->descricao_categoria;
                $jsonData['data'][$key]['y'] = $gasto->total * -1;

                if ($key == 0) {
                    $jsonData[$key]['sliced'] = true;
                } else {
                    $jsonData[$key]['sliced'] = false;
                }
            }
        }

        echo json_encode($jsonData);
    }
    
    public function graficoOrcamentoAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $modelMeta = new Model_Meta();
        $metas = $modelMeta->getGastosMetasUsuario($id_usuario);
        
        $jsonData = array(
            'dataCount' => 0
        );
        
        if ($metas->count() > 0) {
            $jsonData['dataCount'] = $metas->count();
            foreach ($metas as $key => $meta) {
                //$jsonData['receita']['data'][] = $relatorio->total;
                $jsonData['categories']['data'][] = $meta->descricao_categoria;
                $jsonData['total_orcamento']['data'][] = $meta->valor_meta;
                $jsonData['total_despesa']['data'][] = $meta->total * -1;
                $jsonData['porcentagem']['data'][] = $meta->porcentagem;
                $jsonData['projecao']['data'][] = View_Helper_Meta::getProjecaoMeta($meta->porcentagem);
            }
        }

        //Zend_Debug::dump($metas);
        
        echo json_encode($jsonData);
    }

}

