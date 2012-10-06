<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace LibraApp\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
//use Symfony\Component\Yaml\Yaml;
use Zend\Config\Reader\Yaml;

/**
 * Description of YamlReaderFactory
 *
 * @author duke
 */
class YamlReaderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $decoder = 'Symfony\Component\Yaml\Yaml::parse';
        return new Yaml($decoder);
    }
}
