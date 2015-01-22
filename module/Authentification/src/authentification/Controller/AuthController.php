<?php
namespace Authentification\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
 
use Authentification\Model\User;
 
class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
     
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
         
        return $this->authservice;
    }
     
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Authentification\Model\MyAuthStorage');
        }
         
        return $this->storage;
    }
     
    public function getForm()
    {
        if (! $this->form) {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
         
        return $this->form;
    }
     
    public function loginAction()
    {
        //redirection sur la page succès si déjà connecté
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success');
        }
                 
        $form       = $this->getForm();
         
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
     
    public function authenticateAction()
    {
        $form       = $this->getForm();
        $redirect = 'login';
         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                // Vérification authentification
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential($request->getPost('password'));
                                        
                $result = $this->getAuthService()->authenticate();
                switch ($result->getCode()) {
                
                	case Result::FAILURE_IDENTITY_NOT_FOUND:
                		$this->flashmessenger()->addMessage("Identifiant incorrect");
                		break;
                
                	case Result::FAILURE_CREDENTIAL_INVALID:
                		$this->flashmessenger()->addMessage("Mot de passe incorrect");
                		break;
                
                	case Result::SUCCESS:
                		$this->flashmessenger()->addMessage("Connexion réussie");
                		break;
                
                	default:
                		$this->flashmessenger()->addMessage("Erreur inconnue");
                		break;
                }
                /*foreach($result->getMessages() as $message)
                {
                    // sauvegarder le message temporaire dans flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }*/
                 
                if ($result->isValid()) {
                    $redirect = 'success';
                    // Vérif si rememberMe est coché
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //définir encore storage
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    $this->getAuthService()->getStorage()->write($request->getPost('username'));
                }
            }
        }
         
        return $this->redirect()->toRoute($redirect);
    }
     
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
         
        $this->flashmessenger()->addMessage("Vous avez été déconnecté");
        return $this->redirect()->toRoute('login');
    }
}