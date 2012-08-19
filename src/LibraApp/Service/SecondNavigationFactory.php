<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace LibraApp\Service;

use Zend\Navigation\Service\AbstractNavigationFactory;

/**
 * Description of NavigationFactory
 *
 * @author duke
 */
class SecondNavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'leftmenu';
    }
}
