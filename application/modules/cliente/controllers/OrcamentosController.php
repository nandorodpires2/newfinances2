<?php

class Cliente_OrcamentosController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
     
        $id_usuario = Zend_Auth::getInstance()->getIdentity()->id_usuario;
        
        $mes  = $this->_getParam("mes_meta", date('m'));
        $ano = $this->_getParam('ano_meta', date('Y'));
        
        $modelMeta = new Model_Meta();
        
        $metas = $modelMeta->getGastosMetasUsuario($id_usuario);
        $this->view->metas = $metas;
        
        $total_meta = $modelMeta->getTotalMetaMes($id_usuario, $mes, $ano);
        if ($total_meta > 0) {
        $this->view->total_meta = $total_meta;
        
        $total_gastos = $modelMeta->getTotalGastoMetas($id_usuario, $mes, $ano);
        $this->view->total_gastos = $total_gastos;
        
        $porcentagem_orcamento = ($total_gastos * 100) / $total_meta;        
        $this->view->porcentagem_orcamento = $porcentagem_orcamento;      
        }
    }
    
    public function novoOrcamentoAction() {
        
        $modelMeta = new Model_Meta();
        
        $formClienteMetasMeta = new Form_Cliente_Metas_Meta();
        
        $modelMeta = new Model_Meta();
        
        $formClienteMetasMeta->getElement('repetir')->getDecorator('label')->setOption('placement', 'APPEND');
        $this->view->formMeta = $formClienteMetasMeta;
        
        if ($this->_request->isPost()) {
            $dadosMeta = $this->_request->getPost();
            if ($formClienteMetasMeta->isValid($dadosMeta)) {
                $dadosMeta = $formClienteMetasMeta->getValues();
                
                $dadosMeta['valor_meta'] = View_Helper_Currency::setCurrencyDb($dadosMeta['valor_meta'], "positivo");
                $dadosMeta['data_cadastro'] = Controller_Helper_Date::getDatetimeNowDb();
                
                try {
                    $modelMeta->insert($dadosMeta);                    
<<<<<<< HEAD
                    
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
                            $modelMeta->insert($dadosInsert);
                        }
                    }
                    
                    $this->_helper->flashMessenger->addMessage(array(
                        'class' => 'bg-success text-success padding-10px margin-10px-0px',
                        'message' => "Orçamento cadastrado com sucesso!"
                    ));
                    
                    $this->_redirect("cliente/orcamentos");
                    
=======
>>>>>>> 24e0913418d4f5b1c47f58312110f92eb485d0d9
                } catch (Exception $error) {
                    echo $error->getMessage();
                }
                
<<<<<<< HEAD
=======
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
                        $modelMeta->insert($dadosInsert);
                    }
                }
                $this->_redirect("cliente/orcamentos");
>>>>>>> 24e0913418d4f5b1c47f58312110f92eb485d0d9
            }
        }   
    }
    
}

