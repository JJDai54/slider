<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * slider - Slides management module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

use XoopsModules\Slider;
use XoopsModules\Slider\Helper;
use XoopsModules\Slider\Constants;

include_once XOOPS_ROOT_PATH . '/modules/slider/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_slider_slides_show($options)
{
//echo "<hr><pre>" . print_r($options, true ). "</pre><hr>";
    include_once XOOPS_ROOT_PATH . '/modules/slider/class/slides.php';
    $myts = MyTextSanitizer::getInstance();
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    $block       = [];
    $typeBlock   = $options[0];
    $limit       = $options[1];
    $lenghtTitle = $options[2];
    $helper      = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    $crSlides = new \CriteriaCompo();
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    switch ($typeBlock) {
        case 'last':
        default:
            // For the block: slides last
            $crSlides->setSort('');
            $crSlides->setOrder('DESC');
            break;
        case 'new':
            // For the block: slides new
            $crSlides->add(new \Criteria('', \DateTime::createFromFormat(_SHORTDATESTRING), '>='));
            $crSlides->add(new \Criteria('', \DateTime::createFromFormat(_SHORTDATESTRING) + 86400, '<='));
            $crSlides->setSort('');
            $crSlides->setOrder('ASC');
            break;
        case 'hits':
            // For the block: slides hits
            $crSlides->setSort('sld_hits');
            $crSlides->setOrder('DESC');
            break;
        case 'top':
            // For the block: slides top
            $crSlides->setSort('sld_top');
            $crSlides->setOrder('ASC');
            break;
        case 'random':
            // For the block: slides random
            $crSlides->setSort('RAND()');
            break;
    }

    $crSlides->setLimit($limit);
    $slidesAll = $slidesHandler->getAll($crSlides);
    unset($crSlides);
    if (\count($slidesAll) > 0) {
        foreach (\array_keys($slidesAll) as $i) {
            $block[$i]['sld_short_name'] = $myts->htmlSpecialChars($slidesAll[$i]->getVar('sld_short_name'));
            $block[$i]['title'] =  $slidesAll[$i]->getVar('sld_title');
            $block[$i]['description'] = $slidesAll[$i]->getVar('sld_description');
            $block[$i]['read_more'] = $myts->htmlSpecialChars($slidesAll[$i]->getVar('sld_read_more'));
            $block[$i]['weight'] = $myts->htmlSpecialChars($slidesAll[$i]->getVar('sld_weight'));
            $block[$i]['date_begin'] = $slidesAll[$i]->getVar('sld_date_begin');
            $block[$i]['date_end'] = $slidesAll[$i]->getVar('sld_date_end');
            $block[$i]['actif'] = $slidesAll[$i]->getVar('sld_actif');
            $block[$i]['always_visible'] = $slidesAll[$i]->getVar('sld_always_visible');
            $block[$i]['theme'] = $slidesAll[$i]->getVar('sld_theme');
            $block[$i]['image'] = $slidesAll[$i]->getVar('sld_image');
        }
    }

    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_slider_slides_edit($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/slider/class/slides.php';
    $helper = Helper::getInstance();
    $slidesHandler = $helper->getHandler('Slides');
    $GLOBALS['xoopsTpl']->assign('slider_upload_url', SLIDER_UPLOAD_URL);
    $form = _MB_SLIDER_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='".$options[0]."' />";
    $form .= "<input type='text' name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' />&nbsp;<br>";
    $form .= _MB_SLIDER_TITLE_LENGTH . " : <input type='text' name='options[2]' size='5' maxlength='255' value='" . $options[2] . "' /><br><br>";
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    $crSlides = new \CriteriaCompo();
    $crSlides->add(new \Criteria('sld_id', 0, '!='));
    $crSlides->setSort('sld_id');
    $crSlides->setOrder('ASC');
    $slidesAll = $slidesHandler->getAll($crSlides);
    unset($crSlides);
    $form .= _MB_SLIDER_SLIDES_TO_DISPLAY . "<br><select name='options[]' multiple='multiple' size='5'>";
    $form .= "<option value='0' " . (\in_array(0, $options) == false ? '' : "selected='selected'") . '>' . _MB_SLIDER_ALL_SLIDES . '</option>';
    foreach (\array_keys($slidesAll) as $i) {
        $sld_id = $slidesAll[$i]->getVar('sld_id');
        $form .= "<option value='" . $sld_id . "' " . (\in_array($sld_id, $options) == false ? '' : "selected='selected'") . '>' . $slidesAll[$i]->getVar('sld_short_name') . '</option>';
    }
    $form .= '</select>';

    return $form;

}
