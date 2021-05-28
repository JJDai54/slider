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
class Slider_2_02
{
    //----------------------------------------------------

    /**
     * @param \XoopsModule $module
     * @param             $options
     */
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->alterTable_slider();
    }

    //----------------------------------------------------
    public function alterTable_slider()
    {
  global $xoopsDB;
  
  $tbl = $xoopsDB->Prefix("slider_slides");

$sql = <<<__sql__
ALTER TABLE `{$tbl}` 
ADD `sld_button_title` VARCHAR(80) NOT NULL ,
ADD `sld_style_title` TEXT NOT NULL ,
ADD `sld_style_description` TEXT NOT NULL ,
ADD `sld_style_button` TEXT NOT NULL ;
__sql__;



    //----------------------------------------------
    $ok = $xoopsDB->queryF($sql);

  //$ok = true;
//jexit; 
 return $ok;



}


    //-----------------------------------------------------------------
}   // fin de la classe
