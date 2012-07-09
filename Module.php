<?php

namespace LibraApp;

//use Zend\Mvc\ModuleRouteListener;
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
        $eventManager   = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'setModuleAwareRouter'), 1);
        //$moduleRouteListener = new ModuleRouteListener();
        //$moduleRouteListener->attach($eventManager);
        $translator   = $e->getApplication()->getServiceManager()->get('translator');
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
        if ($moduleName && $controllerName) $controllerName = $moduleName . '-' . $controllerName;
        $routeMatch->setParam('controller', $controllerName);
    }

}
