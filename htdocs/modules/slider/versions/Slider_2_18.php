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
class Slider_2_18
{
    //----------------------------------------------------

    /**
     * @param \XoopsModule $module
     * @param             $options
     */
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->updateTable_themes();
    }

    //----------------------------------------------------
/**************************************************
 *
 **************************************************/
    public function updateTable_themes()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('slider_themes');

$sql = <<<__sql__
ALTER TABLE {$tbl} 
ADD `theme_mycss` VARCHAR(80) NOT NULL ;
__sql__;


    //----------------------------------------------
    $ok = $xoopsDB->queryF($sql);

 return $ok;

}


    //-----------------------------------------------------------------
}   // fin de la classe
