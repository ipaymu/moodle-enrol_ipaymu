<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Contains the mathematical constants to work with ipaymu Plugin.
 *
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_ipaymu;

/**
 * Stores all of the mathematical constants used in the plugin
 *
 * @author  2024 Syaifudin <syaifudin@ipaymu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ipaymu_mathematical_constants {
    /**
     * @var int Multiplier for turning days to minutes
     */
    public const ONE_DAY_IN_HOURS = 24;

    /**
     * @var int Multiplier for turning hours to minutes
     */
    public const HOUR_IN_MINUTES = 60;

    /**
     * @var int Multiplier for turning minutes to seconds
     */
    public const MINUTE_IN_SECONDS = 60;

    /**
     * @var int Multiplier for turning seconds to milliseconds
     */
    public const SECOND_IN_MILLISECONDS = 1000;

    /**
     * @var int One product
     */
    public const ONE_PRODUCT = 1;

    /**
     * @var int One product
     */
    public const ONE_DAY_IN_SECONDS = 86400;
}
