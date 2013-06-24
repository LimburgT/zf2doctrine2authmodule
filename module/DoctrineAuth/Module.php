<?php
namespace DoctrineAuth;

use DoctrineAuth\Model\DoctrineAuth;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;

class Module implements \Zend\ModuleManager\Feature\AutoloaderProviderInterface
{
    
    public function getAutoloaderConfig()
    {
        return array(
                'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__.'/autoload_classmap.php',
                ),
                'Zend\Loader\StandardAutoloader' => array(
                    'namespaces' => array(
                        __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                        ),
                    ),
                );
    }
    
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            "factories" => array(
                "DoctrineAuth\Model\MyAuthStorage" => function($serviceManager)
                {
                    return new \DoctrineAuth\Model\MyAuthStorage("myauthstorage");
                },
                "AuthService"=> function($serviceManager)
                {
                    $authService = new AuthenticationService();
                    $authService->setStorage($serviceManager->get('DoctrineAuth\Model\MyAuthStorage'));
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },
            ),
        );
    }

}

?>
