<?php

namespace XoopsModules\Slider;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  slider
 *
 * @package      \module\slider\class
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <owners@zyspec.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since        
 */

use XoopsModules\Slider;
use \XoopsModules\Xmf;

include_once XOOPS_ROOT_PATH . "/Frameworks/moduleclasses/moduleadmin/moduleadmin.php";

// $f = XOOPS_ROOT_PATH . "/Frameworks/moduleclasses/moduleadmin/moduleadmin.php";
// if (is_readable($f)){
// echo "<hr>===>{$f}<br>lecture ok<hr>";
// }else{
// echo "<hr>===>{$f}<br>pas ok<hr>";
}


/**
 * Class aboutSlider
 */
 
class aboutSlider  extends ModuleAdmin
{
    public function __construct(){
    }

    public function renderAbout($business = '', $logo_xoops = true)
    {
        $this->addAssets();
        $path         = XOOPS_URL . '/Frameworks/moduleclasses/icons/32/';
        $date         = preg_replace('/-\\\/', '/', $this->_obj->getInfo('release_date')); // make format a little more forgiving
        $date         = explode('/', $date);
        $author       = explode(',', $this->_obj->getInfo('author'));
        $nickname     = explode(',', $this->_obj->getInfo('nickname'));
        $release_date = formatTimestamp(mktime(0, 0, 0, $date[1], $date[2], $date[0]), 's');
        $module_dir   = $this->_obj->getVar('dirname');
        $module_info  = "<div id=\"about\"><label class=\"label_after\">" . _AM_MODULEADMIN_ABOUT_DESCRIPTION . "</label>\n"
                      . "<text>" . $this->_obj->getInfo('description') . "</text><br>\n"
                      . "<label class=\"label_after\">" . _AM_MODULEADMIN_ABOUT_UPDATEDATE . "</label>\n"
                      . "<text class=\"bold\">" . formatTimestamp($this->_obj->getVar('last_update'), 'm') . "</text><br>\n"
                      . "<label class=\"label_after\">" . _AM_MODULEADMIN_ABOUT_MODULESTATUS . "</label>\n"
                      . "<text>" . $this->_obj->getInfo('module_status') . "</text><br>\n"
                      . "<label class=\"label_after\">" . _AM_MODULEADMIN_ABOUT_WEBSITE . "</label>\n"
                      . "<text><a class=\"tooltip\" href=\"http://" . $this->_obj->getInfo('module_website_url') . "\" rel=\"external\" title=\""
                      . $this->_obj->getInfo('module_website_name') . " - " . $this->_obj->getInfo('module_website_url') . "\">"
                      . $this->_obj->getInfo('module_website_name') . "</a></text>\n"
                      . "</div>\n";
        $authorArray  = array();
        foreach ( $author as $k => $aName ) {
            $authorArray[$k] = ( isset( $nickname[$k] ) && ( '' != $nickname[$k] ) ) ? "{$aName} ({$nickname[$k]})" : "{$aName}";
        }
        $license_url = $this->_obj->getInfo('license_url');
        $license_url = preg_match('%^(https?:)?//%', $license_url) ? $license_url : 'http://' . $license_url;
        $website = $this->_obj->getInfo('website');
        $website = preg_match('%^(https?:)?//%', $website) ? $website : 'http://' . $website;

        $ret = "<table>\n<tr>\n"
             . "<td width=\"50%\">\n"
             . "<table>\n<tr>\n<td style=\"width: 100px;\">\n"
             . "<img src=\"" . XOOPS_URL . '/modules/' . $module_dir . '/' . $this->_obj->getInfo('image') . "\" alt=\"" . $module_dir . "\" style=\"float: left; margin-right: 10px;\">\n"
             . "</td><td>\n"
             . "<div style=\"margin-top: 1px; margin-bottom: 4px; font-size: 18px; line-height: 18px; color: #2F5376; font-weight: bold;\">\n"
             . $this->_obj->getInfo('name') . ' ' . $this->_obj->getInfo('version') . ' ' . $this->_obj->getInfo('module_status') . " ({$release_date})\n"
             . "<br>\n"
             . "</div>\n"
             . "<div style=\"line-height: 16px; font-weight: bold;\">\n"
             . _AM_MODULEADMIN_ABOUT_BY . implode(', ', $authorArray) . "\n"
             . "</div>\n"
             . "<div style=\"line-height: 16px;\">\n"
             . "<a href=\"$license_url\" target=\"_blank\" rel=\"external\">" . $this->_obj->getInfo('license') . "</a>\n"
             . "<br>\n"
             . "<a href=\"$website\" target=\"_blank\">" . $this->_obj->getInfo('website') . "</a>\n"
             . "<br>\n"
             . "<br>\n"
             . "</div>\n"
             . "</td></tr>\n";
        if ((1 !== preg_match('/[^a-zA-Z0-9]/', $business)) || (false !== checkEmail($business))) {
            $ret .= "<td colspan=\"2\">"
                  . "<div id=\"about_donate\"><fieldset><legend class=\"label\">Donation</legend><br>\n"
                  . "<div style=\"clear: both; height: 1em;\"></div>\n"
                  . "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_blank\" rel=\external\">\n"
                  . "<input name=\"cmd\" type=\"hidden\" value=\"_donations\">\n"
                  . "<input name=\"business\" type=\"hidden\" value=\"{$business}\">\n"
                  . "<input name=\"currency_code\" type=\"hidden\" value=\"" . _AM_MODULEADMIN_ABOUT_AMOUNT_CURRENCY . "\">\n"
                  . "<label class=\"label_after\" for=\"amount\">" . _AM_MODULEADMIN_ABOUT_AMOUNT . "</label><text><input class=\"donate_amount\" type=\"text\" name=\"amount\" value=\"" . _AM_MODULEADMIN_ABOUT_AMOUNT_SUGGESTED . "\" title=\"" . _AM_MODULEADMIN_ABOUT_AMOUNT_TTL . "\" pattern=\"" . _AM_MODULEADMIN_ABOUT_AMOUNT_PATTERN . "\"></text>\n"
                  . "<br>\n"
                  . "<text><input type=\"image\" name=\"submit\" class=\"donate_button\" src=\"https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif\" alt=\"" . _AM_MODULEADMIN_ABOUT_DONATE_IMG_ALT . "\"></text>\n"
                  . "<img alt=\"\" height=\"1\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" style=\"border-width: 0px;\" width=\"1\">\n"
                  . "</form>\n"
                  . "<br>\n"
                  . "</fieldset>\n"
                  . "</div>\n"
                  . "</td>\n</tr>\n";
        }
        $ret .= "</table>\n";
        $this->addInfoBox( _AM_MODULEADMIN_ABOUT_MODULEINFO );
        $this->addInfoBoxLine( _AM_MODULEADMIN_ABOUT_MODULEINFO, $module_info, '', '', 'information' );
        $ret .= $this->renderInfoBox()
              . "</td>\n"
              . "<td width=\"50%\">\n"
              . "<fieldset><legend class=\"label\">" . _AM_MODULEADMIN_ABOUT_CHANGELOG . "</legend><br>\n"
              . "<div class=\"txtchangelog\">\n";
        $language = empty( $GLOBALS['xoopsConfig']['language'] ) ? 'english' : $GLOBALS['xoopsConfig']['language'];
        $file     = XOOPS_ROOT_PATH . "/modules/{$module_dir}/language/{$language}/changelog.txt";
        if ( !is_file( $file ) && ( 'english' !== $language ) ) {
            $file = XOOPS_ROOT_PATH . "/modules/{$module_dir}/language/english/changelog.txt";
        }
        if ( is_readable( $file ) ) {
            $ret .= ( implode( '<br>', file( $file ) ) ) . "\n";
        } else {
            $file = XOOPS_ROOT_PATH . "/modules/{$module_dir}/docs/changelog.txt";
            if ( is_readable( $file ) ) {
                $ret .= implode( '<br>', file( $file ) ) . "\n";
            }
        }
        $ret .= "</div>\n"
              . "</fieldset>\n"
              . "</td>\n"
              . "</tr>\n"
              . "</table>\n";
        if ( true === $logo_xoops ) {
            $ret .= "<div class=\"center\">"
                  . "<a href=\"https://xoops.org\" target=\"_blank\"><img src=\"{$path}xoopsmicrobutton.gif\" alt=\"XOOPS\" title=\"XOOPS\"></a>"
                  . "</div>";
        }
        return $ret;
    }
    
}
