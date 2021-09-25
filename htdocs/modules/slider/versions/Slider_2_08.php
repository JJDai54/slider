<?php
/**
 * extcal module.
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright           XOOPS Project (https://xoops.org)
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 *
 * @since               2.2
 *
 * @author              JJDai <http://xoops.kiolo.com>
 **/

//----------------------------------------------------
class Slider_2_08
{
    //----------------------------------------------------

    /**
     * @param \XoopsModule $module
     * @param             $options
     */
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->createTable_themes();
    }

    //----------------------------------------------------
/**************************************************
 *
 **************************************************/
    public function createTable_themes()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('slider_themes');

$sql = <<<__sql__
CREATE TABLE $tbl (
  `theme_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme_folder` VARCHAR(80) NOT NULL DEFAULT '',
  `theme_random`  VARCHAR(1) NOT NULL DEFAULT 'j',
  `theme_transition`  INT(10) NOT NULL DEFAULT '0',
  `theme_tpl_slider` VARCHAR(80) NOT NULL DEFAULT '',
  `theme_status`  INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB;
__sql__;

    //----------------------------------------------
    $ok = $xoopsDB->queryF($sql);
//exit;
 return $ok;



}


    //-----------------------------------------------------------------
}   // fin de la classe
