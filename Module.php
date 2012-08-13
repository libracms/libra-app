<?php

namespace LibraApp;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';
        $config['di']['instance'] = include __DIR__ . '/config/di.php';
        $config = array_merge_recursive($config, include __DIR__ . '/config/libra-app.php');
        return $config;
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

    /**
     * executes on boostrap
     * @param \Zend\Mvc\MvcEvent $e
     * @return null
     */
    public function onBootstrap(MvcEvent $e)
    {
        $e->getViewModel()->setTemplate('layout/default/layout');
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminRouterListener'), 1);
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminAppListener'), 1);
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setModuleAwareRouter'), 1);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $translator   = $e->getApplication()->getServiceManager()->get('translator');
    }

    /**
     * add admin- prefix to route admin-default and others admin- routers
     * @param MvcEvent $e
     */
    public function adminRouterListener(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if ( strpos($routeMatch->getMatchedRouteName(), 'admin-') === 0
                && (strpos($controllerName, 'admin-') !== 0)) {
            $routeMatch->setParam('controller', 'admin-' . $controllerName);
        }
    }

    /**
     * Checks controller name to contain admin- prefix
     * and add admin configurations like layout
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function adminAppListener(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if ($routeMatch->getMatchedRouteName() !== 'admin-default'
                && strpos($controllerName, 'admin-') !== 0) {
            return;
        }
        $e->getViewModel()->setTemplate('admin-layout/default/layout');
    }

    /**
     * set router scheme to /module-name/controller-name/action
     * @param MvcEvent $e
     */
    public function setModuleAwareRouter(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        $moduleName     = $routeMatch->getParam('module');
        if ($moduleName && $controllerName) {
            $controllerName = $moduleName . '/' . $controllerName;
            $routeMatch->setParam('controller', $controllerName);
        }
    }

}
