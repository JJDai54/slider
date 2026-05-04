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

CREATE TABLE news_topics (
  topic_id          SMALLINT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  topic_pid         SMALLINT(4) UNSIGNED NOT NULL DEFAULT '0',
  topic_title       VARCHAR(255)         NOT NULL DEFAULT '',
  topic_weight      SMALLINT(4) UNSIGNED NOT NULL DEFAULT '0',
  topic_imgurl      VARCHAR(50)          NOT NULL DEFAULT '',
  menu              TINYINT(1)           NOT NULL DEFAULT '0',
  topic_frontpage   TINYINT(1)           NOT NULL DEFAULT '1',
  topic_rssurl      VARCHAR(255)         NOT NULL DEFAULT '',
  topic_description TEXT                 NOT NULL,
  topic_color       VARCHAR(10)           NOT NULL DEFAULT '000000',
  topic_color_set   VARCHAR(50)          NOT NULL default '',
  PRIMARY KEY (topic_id),
  KEY pid (topic_pid),
  KEY topic_title (topic_title),
  KEY menu (menu)
)

*/
use XoopsModules\Slider;

class Slider_News extends Slider_Plugin
{
var $options = array(
            'table'        => 'news_topics',
            'fld_id'       => 'topic_id',
            'fld_pid'      => 'topic_pid',
            'fld_name'     => 'topic_title',
            'fld_weight'   => 'topic_weight',
            'permView'     => 'news_view',
//            'captionAll'   => _ALL,
            'catPage'      => 'index.php',
            'catParamName' => 'storytopic');

    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
$this->options['captionAll'] = _MB_SLD_NEWS_ALL_STORIES;

        $permsNames = $this->getPermsissionsNames();
        $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
          
        //Items absoluts (news, nouvel articles, statistique, ...)
    // --- Soumettre un article
        if (in_array('news_submit',$permsNames)){
          $mainMenu['submit']['url'] = $moduleUrl . "/submit.php";
          $mainMenu['submit']['lib'] = _MB_SLD_NEWS_SUBMIT;
        }
    
    // --- Valider les articles les articles
        if (in_array('news_approve',$permsNames)){
          $mainMenu['approve']['url'] = $moduleUrl . "/admin/index.php?op=newarticle";
          $mainMenu['approve']['lib'] = _MB_SLD_NEWS_APPROVE_STORYES;
        }

        if (in_array('news_view',$permsNames)){
    // --- Index des categories
          $mainMenu['topicsIndex']['url'] = $moduleUrl . "/topics_directory.php";
          $mainMenu['topicsIndex']['lib'] = _MB_SLD_NEWS_TOPICS_INDEX;
    
    // --- Archives
          $mainMenu['archives']['url'] = $moduleUrl . "/archive.php";
          $mainMenu['archives']['lib'] = _MB_SLD_NEWS_ARCHIVES;
    
    // --- Annuaire des auteurs
          $mainMenu['whoswho']['url'] = $moduleUrl . "/whoswho.php";
          $mainMenu['whoswho']['lib'] = _MB_SLD_NEWS_WHOS_WHO;
        }
        return $mainMenu;
    }

  } // fin de la classe
?>