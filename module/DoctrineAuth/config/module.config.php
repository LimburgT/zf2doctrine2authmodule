<?php
namespace DoctrineAuth;

return array(
    'controllers' => array(
        'invokables' => array(
            'DoctrineAuth\Controller\DoctrineAuth' => 'DoctrineAuth\Controller\DoctrineAuthController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DoctrineAuth\Controller',
                        'controller' => 'DoctrineAuth',
                        'action' => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action]',
                            'constraints' => array(
                                'route' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(),
                            ),
                        ),
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DoctrineAuth\Controller',
                        'controller' => 'DoctrineAuth',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'DoctrineAuth' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'DoctrineAuth\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => 
                function(Entity\User $user, $passwordGiven) 
                {
                    if ($user->getPassword() == sha1($passwordGiven.$user->getSalt()))
                    {
                        return true;
                    }
                    return false;
                },
            ),
        ),
    ),
);
                