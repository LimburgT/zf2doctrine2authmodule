<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager        = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // add function authPreDispatch before every action in every module
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'authPreDispatch'),1);
    }
    
    /**
    * redirect not autentificated user to login route
    */
    public function authPreDispatch(MvcEvent $event)
    { 
        $authenticationService = new AuthenticationService();
        $identity = $authenticationService->getIdentity();
        if( $identity )
        {
            // publish identity to viewmodel for use in layout
            $event->getViewModel()->setVariable('identity', $identity);
            // get username from MyAuthStorage to publish to viewmodel
            $event->getViewModel()->setVariable('username', $event->getApplication()->getServiceManager()->get('DoctrineAuth\Model\MyAuthStorage')->read() );
        }
        // redirect if not logged in and not in route 'login'
        if ( ! $identity && $event->getRouteMatch()->getMatchedRouteName() != "login")
        {
            $url = $event->getRouter()->assemble(array(), array('name' => 'login'));

            $response = $event->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
        }
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
