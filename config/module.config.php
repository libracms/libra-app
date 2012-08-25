<?php
return array(
    'router' => array(
        'default_params' => array(
            'locale' => 'en_GB',
        ),
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
            'admin' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                ),
                'may_terminate' => true,
                'child_routes' => array(
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
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/',
                            'defaults' => array(
                                'module'     => 'libra-app',
                                'controller' => 'index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'libra-app/index'           => 'LibraApp\Controller\IndexController',
            'libra-app/admin-index'     => 'LibraApp\Controller\AdminIndexController',
            'libra-app/admin-dashboard' => 'LibraApp\Controller\AdminDashboardController',
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
    ),

    'translator' => array(
        'locale' => array(
            'en_GB',
            //'ru_RU', //fallback language
        ),
        'translation_patterns' => array(
            array(
                'type'        => 'phparray',
                'base_dir'    => __DIR__ . '/../locale',
                'text_domain' => 'default',
                'pattern'     => '%s.php',
            ),
        ),
        /*'translation_files' => array(
            array(
                'type' => 'phparray',
                'filename' => __DIR__ . '/../language/en_GB.php',
                'text_domain' => 'default',
                'locale' => 'en_GB',
            ),
            array(
                'type' => 'phparray',
                'filename' => __DIR__ . '/../language/ru_RU.php',
                'text_domain' => 'default',
                'locale' => 'ru_RU',
            ),
        ),*/
    ),

    //avoid error set empty navigation
    'navigation' => array(
        'default' => array(),
        'admin-default' => array(),
    ),
);
