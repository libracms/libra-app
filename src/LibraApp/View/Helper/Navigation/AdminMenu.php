<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace LibraApp\View\Helper\Navigation;

use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\AbstractPage;
use Zend\View;
use Zend\View\Exception;
use Zend\View\Helper\Navigation\Menu;

/**
 * Description of AdminMenu
 *
 * @author duke
 */
class AdminMenu extends Menu
{
    /**
     * CSS class to use for the ul element
     *
     * @var string
     */
    protected $ulClass = 'nav';

    /**
     * Whether only active branch should be rendered
     *
     * @var bool
     */
    protected $onlyActiveBranch = false;

    /**
     * Whether labels should be escaped
     *
     * @var bool
     */
    protected $escapeLabels = true;

    /**
     * Whether parents should be rendered when only rendering active branch
     *
     * @var bool
     */
    protected $renderParents = true;

    /**
     * Partial view script to use for rendering menu
     *
     * @var string|array
     */
    protected $partial = null;

    public function render($container = null)
    {

    }
}
