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

/**
 * Interface  Constants
 */
interface Constants
{
    // Constants for tables
    const TABLE_SLIDES = 0;

    // Constants for status
    public const STATUS_NONE      = 0;
    public const STATUS_OFFLINE   = 1;
    public const STATUS_SUBMITTED = 2;
    public const STATUS_APPROVED  = 3;
    public const STATUS_BROKEN    = 4;



   public const PERIODICITY_ALL      = 0; // tout
   public const PERIODICITY_ALWAYS   = 1; // toujurs
   public const PERIODICITY_FLOAT    = 2; // periode flottante
   public const PERIODICITY_WEEK     = 3; // week
   public const PERIODICITY_MONTH    = 4; // month
   public const PERIODICITY_BIMONTLY = 5; // bimestre
   public const PERIODICITY_QUATER   = 6; // trimestre
   public const PERIODICITY_SEMESTER = 7; // semestre
   public const PERIODICITY_YEAR     = 8; // year

   public const ALL = '(*)'; 
}
