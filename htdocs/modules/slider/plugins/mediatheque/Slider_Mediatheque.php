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
Le plugin doit retourner un tableau de laforma 
[]
    [item1]
        [id]
        [libellé]
        [url]
    [item2]
        [id]
        [libellé]
        [url]

*/

class Slider_Mediatheque extends Slider_Plugin    
{
var $options = array();

/*
var $options = array(
            'table'        => 'media__typemedia',
            'fld_id'       => 'idTypemedia',
            'fld_pid'      => '',
            'fld_name'     => 'nom_fr',
            'fld_weight'   => '',
            'fld_active'   => '',
            'permView'     => '',
            'captionAll'   => _MB_SLD_MEDIATHEQUE_ALL_TYPE_MEDIA,
            'catPage'      => 'media.php',
            'catParamName' => 'type_media');
*/
            
    
    
 /* ********************
 *
 *********************** */   
public function getMainMenu(){
    $permsNames = $this->getPermsissionsNames();
    $moduleUrl = XOOPS_URL . "/modules/" . $this->moduleDirName;
    $mainMenu = array();
      
    //Items absoluts (nes, nouvel articles, statistique, ...)
    
    $mainMenu['mediatheque']['url'] = XOOPS_URL . "/modules/{$this->moduleDirName}/media.php";
    $mainMenu['mediatheque']['lib'] = _MB_SLD_MEDIATHEQUE_MEDIATHEQUE;
    
    $mainMenu['modeles']['url'] = XOOPS_URL . "/modules/{$this->moduleDirName}/sommaire.php"; 
    $mainMenu['modeles']['lib'] = _MB_SLD_MEDIATHEQUE_MODELES;
    
    $mainMenu['entites']['url'] = XOOPS_URL . "/modules/{$this->moduleDirName}/entite.php";
    $mainMenu['entites']['lib'] = _MB_SLD_MEDIATHEQUE_ENTITES;
    
    return $mainMenu;

}
    
    
  } // fin de la classe
    


?>