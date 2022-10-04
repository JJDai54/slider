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

/*
Le plugin doit retourner un tableau de laforme 
[]
    [item1]
        [id]
        [libellé]
        [url]
    [item2]
        [id]
        [libellé]
        [url]

CREATE TABLE `xforms_form` (
  `form_id` smallint(5) NOT NULL auto_increment,
  `form_save_db` tinyint(1) NOT NULL default '1',
  `form_send_method` char(1) NOT NULL default 'e',
  `form_send_to_group` smallint(3) NOT NULL default '0',
  `form_send_to_other` varchar(255) NOT NULL default '',
  `form_send_copy` tinyint(1) NOT NULL default '1',
  `form_order` smallint(3) NOT NULL default '0',
  `form_delimiter` char(1) NOT NULL default 's',
  `form_title` varchar(255) NOT NULL default '',
  `form_submit_text` varchar(50) NOT NULL default '',
  `form_desc` text NOT NULL,
  `form_intro` text NOT NULL,
  `form_email_header` text NOT NULL,
  `form_email_footer` text NOT NULL,
  `form_email_uheader` text NOT NULL,
  `form_email_ufooter` text NOT NULL,
  `form_whereto` varchar(255) NOT NULL default '',
  `form_display_style` varchar(1) NOT NULL default 'f',
  `form_color_set` VARCHAR(50) NOT NULL default '',
  `form_begin` int(10) unsigned NOT NULL default '0',
  `form_end` int(10) unsigned NOT NULL default '0',
  `form_active` tinyint(1) NOT NULL default '1',
  `form_answer` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`form_id`),
  KEY `form_order` (`form_order`)
) ENGINE=MyISAM;

*/

use XoopsModules\Slider;
//include_once(XOOPS_ROOT_PATH . "/modules/slider/class/Slider_Plugin.php");
//include_once("../../class/Slider_Plugin.php");

class Slider_Xforms extends Slider_Plugin
{
var $options = array(
            'table'        => 'xforms_form',
            'fld_id'       => 'form_id',
            'fld_pid'      => '',
            'fld_name'     => 'form_title',
            'fld_weight'   => 'form_order',
            'fld_active'   => 'form_active',
            'permView'     => 'xforms_form_access',
//            'captionAll'   => _ALL,
            'catPage'      => 'index.php',
            'catParamName' => 'form_id',
            'where_extra'  => '(form_begin=0 Or form_begin <= CURRENT_TIMESTAMP) AND (form_end=0 Or form_end >= CURRENT_TIMESTAMP)',            
            'sepTitle'     => '');


    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_XFORMS_ALL_CAT;
    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
      
//    $mainMenu['separation1'] = array('url' => '', 'lib' => "<hr>");
    
    return $mainMenu;

}
    
    
  } // fin de la classe
    


?>