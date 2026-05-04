<?php

declare(strict_types=1);


namespace XoopsModules\Slider;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Slides management module for xoops
 *
 * @copyright      2021 XOOPS Project (https://xoops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

use XoopsModules\Slider;


/**
 * Class Object Handler Styles
 */
class StylesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'slider_styles', Styles::class, 'sty_id', 'sty_name');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $i field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Styles in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountStyles($start = 0, $limit = 0, $sort = 'sty_id ASC, sty_name', $order = 'ASC')
    {
        $crCountStyles = new \CriteriaCompo();
        $crCountStyles = $this->getStylesCriteria($crCountStyles, $start, $limit, $sort, $order);
        return $this->getCount($crCountStyles);
    }

    /**
     * Get All Styles in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllStyles($start = 0, $limit = 0, $sort = 'sty_id ASC, sty_name', $order = 'ASC')
    {
        $crAllStyles = new \CriteriaCompo();
        $crAllStyles = $this->getStylesCriteria($crAllStyles, $start, $limit, $sort, $order);
        return $this->getAll($crAllStyles);
    }

    /**
     * Get Criteria Styles
     * @param        $crStyles
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getStylesCriteria($crStyles, $start, $limit, $sort, $order)
    {
        $crStyles->setStart($start);
        $crStyles->setLimit($limit);
        $crStyles->setSort($sort);
        $crStyles->setOrder($order);
        return $crStyles;
    }
/* *************************************************
 * renvoie une liste "id=>name" pour les formSelect 
 * *********************** */

    public function getListKeyName($addNone = false)

    {
        $ret = array();
        $all = $this->getObjects(null, true); 
        if ($addNone) {
            $ret[0] = _AM_SLIDER_STYLE_NONE;
        }     

        foreach (array_keys($all) as $i) {
            $key = $all[$i]->getVar('sty_id');
            $ret[$key] = $all[$i]->getVar('sty_name');
        
        }

        return $ret;
    }

    
}
