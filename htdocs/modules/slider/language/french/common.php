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
 * Wfdownloads module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         wfdownload
 * @since           3.23
 * @author          Xoops Development Team
 */
$moduleDirName      = \basename(\dirname(\dirname(__DIR__)));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

\define('CO_SLIDER_GDLIBSTATUS', 'GD library support: ');
\define('CO_SLIDER_GDLIBVERSION', 'GD Library version: ');
\define('CO_SLIDER_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
\define('CO_SLIDER_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbsnails available)");
\define('CO_SLIDER_IMAGEINFO', 'Server status');
\define('CO_SLIDER_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
\define('CO_SLIDER_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
\define('CO_SLIDER_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
\define('CO_SLIDER_METAVERSION', "<span style='font-weight: bold;'>Downloads meta version:</span> ");
\define('CO_SLIDER_OFF', "<span style='font-weight: bold;'>OFF</span>");
\define('CO_SLIDER_ON', "<span style='font-weight: bold;'>ON</span>");
\define('CO_SLIDER_SERVERPATH', 'Server path to XOOPS root: ');
\define('CO_SLIDER_SERVERUPLOADSTATUS', 'Server uploads status: ');
\define('CO_SLIDER_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
\define('CO_SLIDER_UPLOADPATHDSC', 'Note. Upload path *MUST* contain the full server path of your upload folder.');

\define('CO_SLIDER_PRINT', "<span style='font-weight: bold;'>Print</span>");
\define('CO_SLIDER_PDF', "<span style='font-weight: bold;'>Create PDF</span>");

\define('CO_SLIDER_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
\define('CO_SLIDER_UPGRADEFAILED1', "Update failed - couldn't add new fields");
\define('CO_SLIDER_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
\define('CO_SLIDER_ERROR_COLUMN', 'Could not create column in database : %s');
\define('CO_SLIDER_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
\define('CO_SLIDER_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
\define('CO_SLIDER_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

\define('CO_SLIDER_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');

// Error Msgs
\define('CO_SLIDER_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
\define('CO_SLIDER_ERROR_BAD_REMOVE', 'Could not delete %s');
\define('CO_SLIDER_ERROR_NO_PLUGIN', 'Could not load plugin');

//Help
\define('CO_SLIDER_DIRNAME', \basename(\dirname(\dirname(__DIR__))));
\define('CO_SLIDER_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
\define('CO_SLIDER_BACK_2_ADMIN', 'Back to Administration of ');
\define('CO_SLIDER_OVERVIEW', 'Overview');

//\define('CO_SLIDER_HELP_DIR', __DIR__);

//help multi-page
\define('CO_SLIDER_DISCLAIMER', 'Disclaimer');
\define('CO_SLIDER_LICENSE', 'License');
\define('CO_SLIDER_SUPPORT', 'Support');

//Sample Data
\define('CO_SLIDER_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
\define('CO_SLIDER_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
\define('CO_SLIDER_SAVE_SAMPLEDATA', 'Export Tables to YAML');
\define('CO_SLIDER_SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
\define('CO_SLIDER_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
\define('CO_SLIDER_EXPORT_SCHEMA', 'Export DB Schema to YAML');
\define('CO_SLIDER_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
\define('CO_SLIDER_EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
\define('CO_SLIDER_ADD_SAMPLEDATA_OK', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
\define('CO_SLIDER_HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons');
\define('CO_SLIDER_SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons');
\define('CO_SLIDER_CONFIRM', 'Confirm');

//letter choice
\define('CO_SLIDER_BROWSETOTOPIC', "<span style='font-weight: bold;'>Browse items alphabetically</span>");
\define('CO_SLIDER_OTHER', 'Other');
\define('CO_SLIDER_ALL', 'All');

// block defines
\define('CO_SLIDER_ACCESSRIGHTS', 'Access Rights');
\define('CO_SLIDER_ACTION', 'Action');
\define('CO_SLIDER_ACTIVERIGHTS', 'Active Rights');
\define('CO_SLIDER_BADMIN', 'Block Administration');
\define('CO_SLIDER_BLKDESC', 'Description');
\define('CO_SLIDER_CBCENTER', 'Center Middle');
\define('CO_SLIDER_CBLEFT', 'Center Left');
\define('CO_SLIDER_CBRIGHT', 'Center Right');
\define('CO_SLIDER_SBLEFT', 'Left');
\define('CO_SLIDER_SBRIGHT', 'Right');
\define('CO_SLIDER_SIDE', 'Alignment');
\define('CO_SLIDER_TITLE', 'Title');
\define('CO_SLIDER_VISIBLE', 'Visible');
\define('CO_SLIDER_VISIBLEIN', 'Visible In');
\define('CO_SLIDER_WEIGHT', 'Weight');

\define('CO_SLIDER_PERMISSIONS', 'Permissions');
\define('CO_SLIDER_BLOCKS', 'Blocks Admin');
\define('CO_SLIDER_BLOCKS_DESC', 'Blocks/Group Admin');

\define('CO_SLIDER_BLOCKS_MANAGMENT', 'Manage');
\define('CO_SLIDER_BLOCKS_ADDBLOCK', 'Add a new block');
\define('CO_SLIDER_BLOCKS_EDITBLOCK', 'Edit a block');
\define('CO_SLIDER_BLOCKS_CLONEBLOCK', 'Clone a block');

//myblocksadmin
\define('CO_SLIDER_AGDS', 'Admin Groups');
\define('CO_SLIDER_BCACHETIME', 'Cache Time');
\define('CO_SLIDER_BLOCKS_ADMIN', 'Blocks Admin');

//Template Admin
\define('CO_SLIDER_TPLSETS', 'Template Management');
\define('CO_SLIDER_GENERATE', 'Generate');
\define('CO_SLIDER_FILENAME', 'File Name');

//Menu
\define('CO_SLIDER_ADMENU_MIGRATE', 'Migrate');
\define('CO_SLIDER_FOLDER_YES', 'Folder "%s" exist');
\define('CO_SLIDER_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('CO_SLIDER_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('CO_SLIDER_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');
\define('CO_SLIDER_ADMENU_FEEDBACK', 'Feedback');

//Latest Version Check
\define('CO_SLIDER_NEW_VERSION', 'New Version: ');

//DirectoryChecker
\define('CO_SLIDER_AVAILABLE', "<span style='color: green;'>Available</span>");
\define('CO_SLIDER_NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
\define('CO_SLIDER_NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
\define('CO_SLIDER_CREATETHEDIR', 'Create it');
\define('CO_SLIDER_SETMPERM', 'Set the permission');
\define('CO_SLIDER_DIRCREATED', 'The directory has been created');
\define('CO_SLIDER_DIRNOTCREATED', 'The directory cannot be created');
\define('CO_SLIDER_PERMSET', 'The permission has been set');
\define('CO_SLIDER_PERMNOTSET', 'The permission cannot be set');

//FileChecker
//\define('CO_SLIDER_AVAILABLE', "<span style='color: green;'>Available</span>");
//\define('CO_SLIDER_NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
//\define('CO_SLIDER_NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
//\define('CO_SLIDER_COPYTHEFILE', 'Copy it');
//\define('CO_SLIDER_CREATETHEFILE', 'Create it');
//\define('CO_SLIDER_SETMPERM', 'Set the permission');

\define('CO_SLIDER_FILECOPIED', 'The file has been copied');
\define('CO_SLIDER_FILENOTCOPIED', 'The file cannot be copied');

//\define('CO_SLIDER_PERMSET', 'The permission has been set');
//\define('CO_SLIDER_PERMNOTSET', 'The permission cannot be set');

//image config
\define('CO_SLIDER_IMAGE_WIDTH', 'Image Display Width');
\define('CO_SLIDER_IMAGE_WIDTH_DSC', 'Display width for image');
\define('CO_SLIDER_IMAGE_HEIGHT', 'Image Display Height');
\define('CO_SLIDER_IMAGE_HEIGHT_DSC', 'Display height for image');
\define('CO_SLIDER_IMAGE_CONFIG', '<span style="color: #FF0000; font-size: Small;  font-weight: bold;">--- EXTERNAL Image configuration ---</span> ');
\define('CO_SLIDER_IMAGE_CONFIG_DSC', '');
\define('CO_SLIDER_IMAGE_UPLOAD_PATH', 'Image Upload path');
\define('CO_SLIDER_IMAGE_UPLOAD_PATH_DSC', 'Path for uploading images');

//Preferences
\define('CO_SLIDER_TRUNCATE_LENGTH', 'Number of Characters to truncate to the long text field');
\define('CO_SLIDER_TRUNCATE_LENGTH_DESC', 'Set the maximum number of characters to truncate the long text fields');

//Module Stats
\define('CO_SLIDER_STATS_SUMMARY', 'Module Statistics');
\define('CO_SLIDER_TOTAL_CATEGORIES', 'Categories:');
\define('CO_SLIDER_TOTAL_ITEMS', 'Items');
\define('CO_SLIDER_TOTAL_OFFLINE', 'Offline');
\define('CO_SLIDER_TOTAL_PUBLISHED', 'Published');
\define('CO_SLIDER_TOTAL_REJECTED', 'Rejected');
\define('CO_SLIDER_TOTAL_SUBMITTED', 'Submitted');
