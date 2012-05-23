<?php

namespace LibraApp;

class Module
{
    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';
        $config['di']['instance'] = include __DIR__ . '/config/di.php';
        $config = array_merge($config, include __DIR__ . '/config/libra-app.php');
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
    public function onBootstrap($e)
    {
    }

}
