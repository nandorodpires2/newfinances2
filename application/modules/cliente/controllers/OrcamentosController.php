<?php

class Cliente_OrcamentosController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
     
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $mes  = $this->_getParam("mes_meta", date('m'));
        $ano = $this->_getParam('ano_meta', date('Y'));
        
        $modelMeta = new Model_Meta();
        
        $metas = $modelMeta->getGastosMetasUsuario($id_usuario);
        $this->view->metas = $metas;
        
        $total_meta = $modelMeta->getTotalMetaMes($id_usuario, $mes, $ano);
        $this->view->total_meta = $total_meta;
        
        $total_gastos = $modelMeta->getTotalGastoMetas($id_usuario, $mes, $ano);
        $this->view->total_gastos = $total_gastos;
        
    }
    
    public function novoOrcamentoAction() {
        
        $formClienteMetasMeta = new Form_Cliente_Metas_Meta();
        
        $formClienteMetasMeta->getElement('repetir')->getDecorator('label')->setOption('placement', 'APPEND');
        $this->view->formMeta = $formClienteMetasMeta;
        
        if ($this->_request->isPost()) {
            $dadosMeta = $this->_request->getPost();
            if ($formClienteMetasMeta->isValid($dadosMeta)) {
                $dadosMeta = $formClienteMetasMeta->getValues();
                
                Zend_Debug::dump($dadosMeta); die();
                
                $dadosMeta['valor_meta'] = View_Helper_Currency::setCurrencyDb($dadosMeta['valor_meta'], "positivo");
                $dadosMeta['data_cadastro'] = Controller_Helper_Date::getDatetimeNowDb();
                
                try {
                    $this->_modelMeta->insert($dadosMeta);                    
                } catch (Exception $error) {
                    echo $error->getMessage();
                }
                
                if ($dadosMeta['repetir'] == 1) {
                    $data = $dadosMeta['ano_meta'] . '-' . $dadosMeta['mes_meta'] . '-' . date('d');
                    $zendDate = new Zend_Date($data);                    
                    $dadosInsert = array();
                    $dadosInsert['valor_meta'] = $dadosMeta['valor_meta'];
                    $dadosInsert['id_categoria'] = $dadosMeta['id_categoria'];
                    $dadosInsert['id_usuario'] = $dadosMeta['id_usuario'];
                    $dadosInsert['repetir'] = 0;
                    for ($i = 1; $i <= 12; $i++) {    
                        $dadosInsert['mes_meta'] = $zendDate->addMonth(1)->toString("MM");                        
                        $dadosInsert['ano_meta'] = $zendDate->toString("yyyy");
                        $this->_modelMeta->insert($dadosInsert);
                    }
                }
                $this->_redirect("metas/");
            }
        }   
    }
    
}

