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
CREATE TABLE `xmnews_category` (
  `category_id`             smallint(5) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)            NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)             NOT NULL DEFAULT '',
  `category_douser`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dodate`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_domdate`        tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dohits`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_dorating`       tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_docomment`      tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_weight`         smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmnews_news` (
  `news_id`             mediumint(8) unsigned   NOT NULL auto_increment,
  `news_cid`            smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `news_title`          varchar(255)            NOT NULL default '',
  `news_description`    text,
  `news_news`    		text,
  `news_mkeyword`   	text,
  `news_logo`           varchar(50)             NOT NULL DEFAULT '',
  `news_userid`         smallint(5)  unsigned   NOT NULL default '0',
  `news_date`           int(10)      unsigned   NOT NULL DEFAULT '0',
  `news_mdate`          int(10)      unsigned   NOT NULL DEFAULT '0',
  `news_rating`         double(6,4)             NOT NULL default '0.0000',
  `news_votes`          smallint(5)  unsigned   NOT NULL default '0',
  `news_counter`        smallint(5)  unsigned   NOT NULL DEFAULT '0',
  `news_douser`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_dodate`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_domdate`        tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_dohits`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_dorating`       tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_docomment`      tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `news_status`         tinyint(1)   unsigned   NOT NULL default '0',
  
  PRIMARY KEY  (`news_id`),
  KEY `news_cid` (`news_cid`)
) ENGINE=MyISAM;
*/
use XoopsModules\Slider;

class Slider_Cds_xmnews extends Slider_Plugin
{
var $options = array(
            'table'        => 'xmnews_news',
            'fld_id'       => 'news_id',
            'fld_pid'      => '',
            'fld_name'     => 'news_title',
            'fld_weight'   => '',
            'fld_active'   => 'news_status',
            'permView'     => '',//xmnews_viewabstract //xmnews_viewnews
//            'captionAll'   => _ALL,
            'catPage'      => 'article.php', //   index
            'catParamName' => 'news_id',
            'where_extra'  => 'news_cid IN (1)', //news_cid
            'sepTitle'     => '-');
          
function __construct ($moduleDirName){
    parent::__construct ('xmnews');
    $this->order = 1;
}

 /* ********************
 *
 *********************** */   
public function getMainMenu(){
global $xoopsDB;
$this->options['captionAll'] = _MB_SLD_XMNEWS_ALL_CAT;

    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();

    $lstCats = "3,4,5";
    $tblCats = $xoopsDB->prefix("xmnews_category");
    $tblNews = $xoopsDB->prefix("xmnews_news");
    $sqlCat = "SELECT tc.category_id,tc.category_name,tn.news_id,tn.news_title" 
            .  " FROM {$tblCats} tc, {$tblNews} tn" 
            . " WHERE tc.category_id = tn.news_cid"
            . " AND tc.category_id IN ({$lstCats}) AND tc.category_status = 1 AND tn.news_status = 1"
            . " ORDER BY tc.category_weight, tn.news_title"; 
    $result = $xoopsDB->query($sqlCat);
    $idCat = 0;
    
    
    while($row = $xoopsDB->fetchArray($result)){
//echo "<hr>xmnews<pre>" . print_r($row, true ). "</pre><hr>";    
        if ($idCat != $row['category_id'] ) {
           if ($idCat != 0) {
                $mainMenu[] = $tCat;
           }
           $tCat = array();
           $tCat['url'] = '#';
           $tCat['lib'] = $row['category_name'];
           $tCat['submenu'] = [];
           $idCat = $row['category_id'];
        }
        $tNews = array();
        $tNews['url'] = $moduleUrl . '/article.php?news_id=' .  $row['news_id'];
        $tNews['lib'] = $this->parse_title($row['news_title']);
        $tCat['submenu'][] = $tNews;
        
    }
    $mainMenu[] = $tCat;
    
//echo "<hr>xmnews<pre>" . print_r($mainMenu, true ). "</pre><hr>";    
    
    
    return $mainMenu;

}

    
} // fin de la classe
    


?>