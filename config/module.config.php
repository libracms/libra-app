<?php
return array(
    'router' => array(
        'routes' => array(
            'libra-app' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/libra-app',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LibraApp\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'index' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/index[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'markdown' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/markdown[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Markdown',
                                'action'     => 'view',
                            ),
                        ),
                    ),
                ),
            ),
            'default' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'priority' => -1000,
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
            'admin' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    //insert here you admin routers
                    'home' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/]',
                            'defaults' => array(
                                '__NAMESPACE__' => 'LibraApp\Controller\Admin',
                                //'module'     => 'libra-app',
                                'controller' => 'Index',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'libra-app' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/libra-app',
                            'defaults' => array(
                                '__NAMESPACE__' => 'LibraApp\Controller\Admin',
                                'controller' => 'Index',
                                'action'     => 'index',
                            ),
                        ),
                        'child_routes' => array(
                            'config' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/config',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'LibraApp\Controller\Admin\Config',
                                    ),
                                ),
                                'child_routes' => array(
                                    'general' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/general[/:action]',
                                            'constraints' => array(
                                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            ),
                                            'defaults' => array(
                                                '__NAMESPACE__' => 'LibraApp\Controller\Admin\Config',
                                                'controller' => 'General',
                                                'action'     => 'view',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'index' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/index[/:action]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                        'action'     => 'index',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    //need replace with libra-app name
                    'default' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                        'priority' => -1000,
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
                ),
            ),
        ),
    ),
    //Enable console
    'console' => array(
        'router' => array(
            'routes' => array(
                'updater' => array(
                    'options' => array(
                        'route'    => 'updater [update] [<version-from>] [<version-to>] [--help|-h]:help',
                        'defaults' => array(
                            'controller' => 'LibraApp\Controller\Updater',
                            'action'     => 'update'
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'aliases' => array(
            'libra-app/index' => 'LibraApp\Controller\Index',
            'libra-app/admin-index' => 'LibraApp\Controller\Admin\Index',
        ),
        'invokables' => array(
            'LibraApp\Controller\Index'         => 'LibraApp\Controller\IndexController',
            'LibraApp\Controller\Updater'       => 'LibraApp\Controller\UpdaterController',
            'LibraApp\Controller\Markdown'      => 'LibraApp\Controller\MarkdownController',
            'LibraApp\Controller\Admin\Index'           => 'LibraApp\Controller\Admin\IndexController',
            'LibraApp\Controller\Admin\Dashboard'       => 'LibraApp\Controller\Admin\DashboardController',
            'LibraApp\Controller\Admin\Config\General'  => 'LibraApp\Controller\Admin\Config\GeneralController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/default/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'translator' => array(
        'locale' => array(
            'en-US',  //default locale
            'en-US',  //fallback language
        ),
        'translation_file_patterns' => array(
            array(
                'type'        => 'phparray',
                'base_dir'    => __DIR__ . '/../locale',
                'text_domain' => 'default',
                'pattern'     => '%s.php',
            ),
        ),
    ),

    //avoid error set empty navigation
    'navigation' => array(
        'default' => array(),
        'admin-default' => array(),
    ),

    'service_manager' => array(
        'factories'    => array(
            'ViewResolver' => 'Libra\Mvc\Service\ViewResolverFactory',
            //'Zend\Config\Reader\Yaml' => 'LibraApp\Service\YamlReaderFactory',
            //'Zend\Config\Writer\Yaml' => 'LibraApp\Service\YamlWriterFactory',
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    //default values
    'libra_app' => array(
        'layoutName' => 'default',
        'adminLayoutName' => 'default',
    ),

);
