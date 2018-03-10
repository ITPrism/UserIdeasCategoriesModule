<?php
/**
 * @package      Userideas
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('Prism.init');
jimport('Userideas.init');

$moduleclassSfx = htmlspecialchars($params->get('moduleclass_sfx'));

$app    = JFactory::getApplication();
$option = $app->input->getCmd('option');
$view   = $app->input->getCmd('view');

$parentId = 0;
if (strcmp('com_userideas', $option) === 0 and strcmp('category', $view) === 0) {
    $parentId = (int)$app->input->getInt('id');
}
$parentId = $parentId ?: Prism\Constants::CATEGORY_ROOT;

$showTitle = $params->get('show_title', Prism\Constants::NO);
$showImages = $params->get('show_image', Prism\Constants::NO);
$showDescription = $params->get('show_description', Prism\Constants::NO);

$parentCategory = null;
$activeItemId   = 0;

$items = new Userideas\Category\Categories();
if ($parentId === Prism\Constants::CATEGORY_ROOT) {
    $root       = $items->get();
    $categories = $root->getChildren();
} else {
    $activeItemId     = $parentId;
    $parentCategory   = $items->get($parentId);
    $categories       = $parentCategory->getChildren();
    if (count($categories) === 0) {
        $parentCategory   = $parentCategory->getParent();
        if ($parentCategory !== null) {
            $categories       = $parentCategory->getChildren();
        }
    }
}

$helperBus  = new Prism\Helper\HelperBus($categories);
$helperBus->addCommand(new Userideas\Helper\PrepareParamsHelper());
$helperBus->handle();

// Get number of items.
$numberOfItems   = array();
$showItemsNumber = $params->get('show_items_number', Prism\Constants::NO);
if ($showItemsNumber) {
    $ids = Prism\Utilities\ArrayHelper::getIds($categories);
    if ($parentCategory !== null) {
        $ids[] = (int)$parentCategory->id;
    }

    $statistics    = new Userideas\Statistic\Basic(\JFactory::getDbo());
    $numberOfItems = $statistics->getCategoryItems($ids);
}

require JModuleHelper::getLayoutPath('mod_userideascategories', $params->get('layout', 'default'));
