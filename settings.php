<?php

/**
 * FORCECPF Local
 *
 * @package    local_forcecpf
 * @copyright  2017 FAMASA
 * @license    Commercial
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN) {

    $settings = new admin_settingpage('local_forcecpf', get_string('pluginname', 'local_forcecpf'));
    $ADMIN->add('localplugins', $settings);

    // Message
    $name = 'local_forcecpf/custommessage';
    $title = get_string('custommessage', 'local_forcecpf');
    $description = get_string('custommessagedesc', 'local_forcecpf');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $settings->add($setting);

    // Error Message
    $name = 'local_forcecpf/errormessage';
    $title = get_string('errormessage', 'local_forcecpf');
    $description = get_string('errormessagedesc', 'local_forcecpf');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $settings->add($setting);

}
