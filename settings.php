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
 * The admin global settings for inserting ipaymu credentials
 *
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Check root/lib/adminlib.php for lists of available classes.
    $settings->add(
        new admin_setting_heading(
            'enrol_ipaymu_settings',
            '',
            get_string('pluginname_desc', 'enrol_ipaymu')
        )
    );

    $options = [
        'sandbox' => get_string('environment:sandbox', 'enrol_ipaymu'),
        'production' => get_string('environment:production', 'enrol_ipaymu')
    ];

    $settings->add(
        new admin_setting_configselect(
            'enrol_ipaymu/environment',
            get_string('environment', 'enrol_ipaymu'),
            get_string('environment_desc', 'enrol_ipaymu'),
            'sandbox',
            $options)
        );


    $settings->add(
        new admin_setting_configtext(
            'enrol_ipaymu/ipaymu_va',
            get_string('ipaymu_va', 'enrol_ipaymu'),
            get_string('ipaymu_va_desc', 'enrol_ipaymu'),
            '',
            PARAM_TEXT,
            40)
        );

    $settings->add(
        new admin_setting_configtext(
            'enrol_ipaymu/ipaymu_apikey',
            get_string('ipaymu_apikey', 'enrol_ipaymu'),
            get_string('ipaymu_apikey_desc', 'enrol_ipaymu'),
            '',
            PARAM_TEXT)
        );

    $settings->add(
        new admin_setting_configtext(
            'enrol_ipaymu/ipaymu_va_sandbox',
            get_string('ipaymu_va_sandbox', 'enrol_ipaymu'),
            get_string('ipaymu_va_sandbox_desc', 'enrol_ipaymu'),
            '',
            PARAM_TEXT,
            40)
        );

    $settings->add(
        new admin_setting_configtext(
            'enrol_ipaymu/ipaymu_apikey_sandbox',
            get_string('ipaymu_apikey_sandbox', 'enrol_ipaymu'),
            get_string('ipaymu_apikey_sandbox_desc', 'enrol_ipaymu'),
            '',
            PARAM_TEXT)
        );


    $settings->add(
                    new admin_setting_configtext(
                        'enrol_ipaymu/expiry',
                        get_string('expiry', 'enrol_ipaymu'),
                        get_string('expiry_desc', 'enrol_ipaymu'),
                        24,
                        PARAM_INT)
                );
}
