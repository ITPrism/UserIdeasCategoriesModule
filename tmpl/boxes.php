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
<div class="ui-moditems<?php echo $moduleclassSfx; ?>">
    <div class="row">
    <?php
    foreach ($categories as $category) {
        $itemsNumber = 0;
        $numberHtml  = $showItemsNumber ? ' (0)':'';
        $itemsNumber = 0;
        if ($showItemsNumber and array_key_exists($category->id, $numberOfItems)) {
            $numberHtml = ' ('.(int)$numberOfItems[$category->id].')';
        }

        $title       = htmlspecialchars($category->title, ENT_COMPAT, 'UTF-8');
    ?>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="thumbnail height-300px">
                <?php if ($showImages) {?>
                <a href="<?php echo JRoute::_(UserideasHelperRoute::getCategoryRoute($category->slug));?>">
                <img src="<?php echo $category->params->get('image') ?: 'media/com_userideas/images/no_image_100x100.png';?>" alt="<?php echo $title; ?>">
                </a>
                <?php } ?>
                <div class="caption ">
                    <?php if ($showTitle) {
                    echo '<h3><a href="'.JRoute::_(UserideasHelperRoute::getCategoryRoute($category->slug)).'">'.$title .'</a>'.$numberHtml.'</h3>';
                    }
                    if ($showDescription) {
                        $description = htmlspecialchars(strip_tags($category->description), ENT_COMPAT, 'UTF-8');
                        echo '<p>' . $description . '</p>';
                    } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
