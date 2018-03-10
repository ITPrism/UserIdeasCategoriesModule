<?php
/**
 * @package      Userideas
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
/**
 * @var stdClass $parentCategory
 */
?>
<div class="ui-modcategories<?php echo $moduleclassSfx; ?>">
<?php
$html   = array();
$html[] = '<ul class="ui-mod-navcat">';
foreach ($categories as $category) {
    $active      = '';
    $numberHtml  = $showItemsNumber ? ' (0)':'';
    $itemsNumber = 0;
    if ($showItemsNumber and array_key_exists($category->id, $numberOfItems)) {
        $numberHtml = ' ('.(int)$numberOfItems[$category->id].')';
    }

    $active = '';
    if ((int)$category->id === $activeItemId) {
        $active = ' ui-mod-catnav-active';
    }

    $html[] = '<li class="ui-mod-navcat-li'.$active.'">';
    $html[] = '<a href="' . JRoute::_(UserideasHelperRoute::getCategoryRoute($category->slug)) . '">' . htmlspecialchars($category->title, ENT_COMPAT, 'UTF-8') . $numberHtml.'</a>';
    $html[] = '</li>';
}
$html[] = '</ul>';

if ($parentCategory !== null) {
    $numberHtml  = $showItemsNumber ? ' (0)':'';
    $itemsNumber = 0;
    if ($showItemsNumber and array_key_exists($parentCategory->id, $numberOfItems)) {
        $numberHtml = ' ('.(int)$numberOfItems[$parentCategory->id].')';
    }

    $active = '';
    if ((int)$parentCategory->id === $activeItemId) {
        $active = 'ui-mod-catnav-active';
    }
    ?>
    <ul class="ui-mod-navcat ui-mod-catnav-primary">
        <li class="ui-mod-navcat-li<?php echo $active; ?>">
            <a href="<?php echo JRoute::_(UserideasHelperRoute::getCategoryRoute($parentCategory->slug));?>">
                <?php echo htmlspecialchars($parentCategory->title, ENT_COMPAT, 'UTF-8');?>
                <?php echo $numberHtml; ?>
            </a>
            <?php echo implode("\n", $html); ?>
        </li>
    </ul>
<?php } else {
    echo implode("\n", $html);
} ?>
</div>
