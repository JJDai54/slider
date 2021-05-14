<?php

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
 * slider - Slides management module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        slider
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         JJDai - Email:<jjdelalandre@orange.fr> - Website:<http://jubile.fr>
 */

use XoopsModules\Slider;


/**
 * Class Object Handler Slides
 */
class SlidesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'slider_slides', Slides::class, 'sld_id', 'sld_title');
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
	 * @return mixed reference to the {@link Get} object
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
	 * Get Count Slides in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountSlides($start = 0, $limit = 0, $sort = 'sld_id ASC, sld_title', $order = 'ASC')
	{
		$crCountSlides = new \CriteriaCompo();
		$crCountSlides = $this->getSlidesCriteria($crCountSlides, $start, $limit, $sort, $order);
		return $this->getCount($crCountSlides);
	}

	/**
	 * Get All Slides in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllSlides($criteria, $start = 0, $limit = 0, $sort = 'sld_id ASC, sld_title', $order = 'ASC')
	{
		$crAllSlides = $this->getSlidesCriteria($criteria, $start, $limit, $sort, $order);
		return $this->getAll($crAllSlides);
	}

	/**
	 * Get Criteria Slides
	 * @param        $crSlides
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getSlidesCriteria($crSlides, $start, $limit, $sort, $order)
	{
		$crSlides->setStart($start);
		$crSlides->setLimit($limit);
		$crSlides->setSort($sort);
		$crSlides->setOrder($order);
		return $crSlides;
	}
}
