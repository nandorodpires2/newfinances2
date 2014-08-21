<?php

class Site_UsuariosController extends Zend_Controller_Action {

    public function init() {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }

    public function indexAction() {
        
    }
    
    public function loginAction() {
        
        $modelUsuario = new Model_Usuario();
        
        $formUsuariosLogin = new Form_Site_Login();
        $this->view->formUsuariosLogin = $formUsuariosLogin;
        
        if ($this->getRequest()->isPost()) {
            
            $dadosUsuariosLogin = $this->getRequest()->getPost();            
            if ($formUsuariosLogin->isValid($dadosUsuariosLogin)) {
                $dadosUsuariosLogin = $formUsuariosLogin->getValues();                
                                
                $ZendAuth = Zend_Auth::getInstance();                
                $adapter = $modelUsuario->login($dadosUsuariosLogin);
                $usuarioRow = $modelUsuario->getDadosUsuario($dadosUsuariosLogin['email_usuario']); 
                
                $result = $ZendAuth->authenticate($adapter); 
                
                if ($result->isValid()) {                       
                    $ZendAuth->getStorage()->write($usuarioRow);   
                                        
                    // gravando o log
                    $dadosInsertLog['id_usuario'] = $usuarioRow->id_usuario;
                    $modelUsuarioLogin = new Model_UsuarioLogin();
                    $modelUsuarioLogin->insert($dadosInsertLog);
                    
                    $this->_redirect("cliente/index/");
                } else {         
                    Zend_Debug::dump($result->getMessages());
                }                                
                
            }
        }
        
    }

    public function recuperarSenhaAction() {
        // action body
    }
    
    public function ativarAction() {
        
        $hash = $this->_getParam('hash');
        
        /* busca os dados do hash */
        $modelUsuarioAtivar = new Model_UsuarioAtivar();        
        $dadosHashUsuario = $modelUsuarioAtivar->getDadosUsuarioHash($hash);
        
        $modelUsuario = new Model_Usuario();
        
        /* verificar se esta ativado */
        if (!$dadosHashUsuario->ativado) {
            $dadosAtivar = array(
                'ativado' => 1,
                'data_ativacao' => date('Y-m-d H:i:s')
            );
            $where = "id_usuario = " . $dadosHashUsuario->id_usuario;
            
            $whereUsuario = "id_usuario = " . $dadosHashUsuario->id_usuario;
            try {
                $modelUsuarioAtivar->update($dadosAtivar, $where);
                $modelUsuario->update(array('ativo_usuario' => 1), $whereUsuario);

                $messages = array(
                    'type' => 'success',
                    'class' => 'bg-success text-success padding-10px margin-10px-0px',
                    'message' => 'Conta ativada com sucesso.'
                );
                $this->_helper->flashMessenger->addMessage($messages);
            } catch (ErrorException $erro) {
                $messages = array(
                    'type' => 'danger',
                    'class' => 'bg-danger text-danger padding-10px margin-10px-0px',
                    'message' => 'Houve um erro ao ativar a conta. Favor entrar em contato relatando o problema.'
                );
                $this->_helper->flashMessenger->addMessage($messages);
            }                        
        } else {
            $messages = array(
                'type' => 'danger',
                'class' => 'bg-danger text-warning padding-10px margin-10px-0px',
                'message' => 'Esta conta já foi ativada!'
            );
            $this->_helper->flashMessenger->addMessage($messages);
            
        }
        
        $this->_redirect("usuarios/login");
        
    }

}



