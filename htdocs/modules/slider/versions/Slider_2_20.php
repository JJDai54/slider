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
class Slider_2_20
{
    //----------------------------------------------------

    /**
     * @param \XoopsModule $module
     * @param             $options
     */
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->create_table_styles();
        $this->insert_data_styles();
        $this->updateTable_slides();
    }

    //----------------------------------------------------
/**************************************************
 *
 **************************************************/
    public function create_table_styles()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('slider_styles');

$sql = <<<__sql__
CREATE TABLE $tbl (
  `sty_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sty_name` VARCHAR(80) NOT NULL DEFAULT '',
  `sty_object` VARCHAR(80) NOT NULL DEFAULT '',
  `sty_css` TEXT NOT NULL ,
  PRIMARY KEY (`sty_id`),
  UNIQUE KEY `sty_name` (`sty_name`)  
) ENGINE=InnoDB;
__sql__;




    //----------------------------------------------
    $ok = $xoopsDB->queryF($sql);

 return $ok;

}

/**************************************************
 *
 **************************************************/
    public function insert_data_styles()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('slider_styles');

$id = 1;
$sql = <<<__sql__
INSERT INTO $tbl (sty_id,sty_name,sty_css)
values({$id},"Defaut - Titre ({$id})","color:#496381;
background:#E1D6C9;
opacity: 0.8;
padding: 0px 25px 0px 25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
margin-bottom:15px;");
__sql__;
    $ok = $xoopsDB->queryF($sql);

$id++;
$sql = <<<__sql__
INSERT INTO $tbl (sty_id,sty_name,sty_css)
values({$id},"Defaut - Sous-titre ({$id})","color:#496381;
background:#E1D6C9;
opacity: 0.8;
padding: 0px 25px 0px 25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
margin-bottom:15px;");
__sql__;
    $ok = $xoopsDB->queryF($sql);

$id++;
$sql = <<<__sql__
INSERT INTO $tbl (sty_id,sty_name,sty_css)
values({$id},"Defaut - Bouton ({$id})","color:#496381;
background:#E1D6C9;
opacity: 0.9;
padding:25px;
border-radius: 50px 50px 50px 50px;
margin-left:250px;
margin-right:250px;
padding-bottom : 5px;
padding-top : 5px;");
__sql__;
    $ok = $xoopsDB->queryF($sql);


    //----------------------------------------------
 return $ok;

}

/**************************************************
 *
 **************************************************/
    public function updateTable_slides()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('slider_slides');

$sql = <<<__sql__
ALTER TABLE {$tbl} 
ADD `sld_style_id_title` INT(10) NOT NULL DEFAULT '0' ,
ADD `sld_style_id_subtitle` INT(10) NOT NULL DEFAULT '0' ,
ADD `sld_style_id_button` INT(10) NOT NULL DEFAULT '0' ;
__sql__;

  

    //----------------------------------------------
    $ok = $xoopsDB->queryF($sql);

 return $ok;

}

    //-----------------------------------------------------------------
}   // fin de la classe
