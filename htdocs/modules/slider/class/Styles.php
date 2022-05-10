<?php

declare(strict_types=1);


namespace XoopsModules\Slider;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Slides management module for xoops
 *
 * @copyright      2021 XOOPS Project (https://xoops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

use XoopsModules\Slider;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Styles
 */
class Styles extends \XoopsObject
{
    /**
     * @var int
     */
    public $start = 0;

    /**
     * @var int
     */
    public $limit = 0;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('sty_id', \XOBJ_DTYPE_INT);
        $this->initVar('sty_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('sty_object', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('sty_css', \XOBJ_DTYPE_TXTAREA);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdStyles()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormStyles($action = false)
    {
        $helper = \XoopsModules\Slider\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \sprintf(\_AM_SLIDER_STYLE_ADD) : \sprintf(\_AM_SLIDER_STYLE_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        
        // Form Text styName
        $inpName = new \XoopsFormText(\_AM_SLIDER_STYLE_NAME, 'sty_name', 80, 255, $this->getVar('sty_name'));
        $inpName->setDescription(_AM_SLIDER_STYLE_NAME_DESC);
        $form->addElement($inpName);
        //--------------------------------------------------
        // Form Text styObject
        //finalement pas utile
//         $form->addElement(new \XoopsFormText(\_AM_SLIDER_STYLE_OBJECT, 'sty_object', 50, 255, $this->getVar('sty_object')));
//         $obj = $this->getVar('sty_object');
//         if (!isset($obj)) $obj='title'
//         $inpobject= new \XoopsFormSelect(_AM_SLIDER_STYLE_OBJECT, 'sty_object', $slideImg);   
//             //$inpImg->setDescription(_AM_SLIDER_IMG_UPLODED_DESC);        
//             $inpobject->addOptionArray($listImg);   
//         }
        //--------------------------------------------------
        
        
        // Form Editor TextArea styCss
        $inpCss = new \XoopsFormTextArea(\_AM_SLIDER_STYLE_CSS, 'sty_css', $this->getVar('sty_css', 'e'), 12, 47);
        $inpCss->setDescription(_AM_SLIDER_SLIDE_STYLE_DESC);
        $inpCss->setExtra("style='width:400px;'");
        $form->addElement($inpCss);
        
        
        
        
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $this->start));
        $form->addElement(new \XoopsFormHidden('limit', $this->limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesStyles($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Slider\Helper::getInstance();
        $utility = new \XoopsModules\Slider\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']        = $this->getVar('sty_id');
        $ret['name']      = $this->getVar('sty_name');
        $ret['object']    = $this->getVar('sty_object');
        $ret['css']       = \strip_tags($this->getVar('sty_css', 'e'));
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['css_short'] = $utility::truncateHtml($ret['css'], $editorMaxchar);
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayStyles()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
