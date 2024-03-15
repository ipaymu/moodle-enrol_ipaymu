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
 * Contains helper class to work with ipaymu Plugin.
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
class ipaymu_status_codes {
    /**
     * @var string ipaymu has received payment from the user. Could still be waiting for callback
     */
    public const CHECK_STATUS_SUCCESS = 'Berhasil';

    /**
     * @var string ipaymu has not received payment from the user.
     */
    public const CHECK_STATUS_PENDING = 'Pendding';

    /**
     * @var string Transaction is canceled. Possibly from being expired.
     */
    public const CHECK_STATUS_CANCELED = 'Expired';
}
