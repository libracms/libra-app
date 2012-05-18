<?php
return array(
    'di' => array(
        'instance' => array(

            //Setup aliases

            //Alias for every controller prefixed by lowercase namespace
            'alias' => array(
                'libra-app-index'         => 'LibraApp\Controller\IndexController',
            ),

            /**
             * View helper(s)
             */
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        '_'               => 'Zend\View\Helper\Translator',
                    ),
                ),
            ),

            // Setup for controllers.

            // Injecting the plugin broker for controller plugins into
            // the action controller for use by all controllers that
            // extend it
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),

            // Setup for router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'default' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/[:controller[/:action[/:param[/:param2[/:param3]]]]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'param'      => '[a-zA-Z0-9_-]*',
                                    'param2'     => '[a-zA-Z0-9_-]*',
                                    'param3'     => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'namespace'  => 'LibraApp',
                                    'controller' => 'libra-app-index',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/',
                                'defaults' => array(
                                    'namespace'  => 'LibraApp',
                                    'controller' => 'libra-app-index',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                    ),
                ),
            ),

            // Setup for the view layer.

            // Using the PhpRenderer, which just handles html produced by php 
            // scripts
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            // Defining how the view scripts should be resolved by stacking up
            // a Zend\View\Resolver\TemplateMapResolver and a
            // Zend\View\Resolver\TemplatePathStack
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),
            // Defining where the application layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        //'application/layout/layout' => __DIR__ . '/../view/application/layout/layout.phtml',
                        //'libra-app/layout/layout' => __DIR__ . '/../view/libra-app/layout/default/layout.phtml',
                    ),
                ),
            ),
            // Defining where to look for views. This works with multiple paths,
            // very similar to include_path
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'libra-glob'    => __DIR__ . '/../view',
                        'libra-app'     => __DIR__ . '/../view/libra-app',
                        //'layout'    => __DIR__ . '/../view/libra-app/layout/default',
                        //'libra-app/layout' => __DIR__ . '/../view/libra-app/default/layout',
                        //'modules-override' => '../view/',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'libra-app/layout/layout',
                ),
            ),
            // Injecting the router into the url helper
            'Zend\View\Helper\Url' => array(
                'parameters' => array(
                    'router' => 'Zend\Mvc\Router\RouteStack',
                ),
            ),
            // Configuration for the doctype helper
            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            // View script rendered in case of 404 exception
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions'     => true,
                    'notFoundTemplate'      => 'libra-app/layout/error/404',
                ),
            ),
            // View script rendered in case of other exceptions
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'libra-app/layout/error/exception',
                ),
            ),
        ),
    ),
);
