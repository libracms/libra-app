<?php
return array(
    'router' => array(
        'routes' => array(
            'default' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/[:module[/:controller[/:action[/:param[/:param1[/:param2]]]]]]',
                    'constraints' => array(
                        'module'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'param'      => '[a-zA-Z0-9_-]*',
                        'param1'     => '[a-zA-Z0-9_-]*',
                        'param2'     => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'module'     => 'libra-app',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'module'     => 'libra-app',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controller' => array(
        'classes' => array(
            'libra-app-index' => 'LibraApp\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'helper_map' => array(
            '_' => 'Zend\View\Helper\Translator',
        ),
    ),
);
