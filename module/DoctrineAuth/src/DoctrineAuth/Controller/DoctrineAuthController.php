<?php
namespace DoctrineAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use DoctrineAuth\Model\User;

class DoctrineAuthController extends AbstractActionController
{

    protected $form;
    protected $storage;
    protected $authservice;

    public function getAuthService()
    {
        if (!$this->authservice)
        {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

    public function getForm()
    {
        if(!$this->form)
        {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
        return $this->form;
    }
    
    public function getSessionStorage()
    {
        if(! $this->storage)
        {
            $this->storage = $this->getServiceLocator()->get('DoctrineAuth\Model\MyAuthStorage');
        }
        return $this->storage;
    }
    
    public function loginAction()
    {
        // if logged in, redirect to succes page
        if( $this->getAuthService()->hasIdentity() )
        {
            return $this->redirect()->toRoute("success");
        }
        $form   = $this->getForm();
        
        return array(
            'form'      => $form,
            'messages'  => $this->flashMessenger()->getMessages()
        );
    }
    
    public function authenticateAction()
    {
        $form = $this->getForm();
        $redirect = "login";
        
        $request = $this->getRequest();
        if( $request->isPost() )
        {
            $form->setData($request->getPost());
            if( $form->isValid())
            {
                // check authentification
                $this->getAuthService()->getAdapter()
                        ->setIdentity($request->getPost("username"))
                        ->setCredential($request->getPost("password"));
                $result = $this->getAuthService()->authenticate();
            }
            foreach($result->getMessages() as $message)
            {
                // save message into flashmessenger
                $this->flashMessenger()->addMessage($message);
            }
            if($result->isValid())
            {
                // Auf home-Route umleiten (die hoffentlich da ist), Todo: angerfagte Route merken und nach Auth dahin umleiten
                $redirect = "home";
                $this->getSessionStorage()->write($request->getPost("username"));
            }
        }
        return $this->redirect()->toRoute($redirect);
    }
    
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        
        $this->flashMessenger()->addMessage("You have been logged out!");
        return $this->redirect()->toRoute("login");
    }
}

