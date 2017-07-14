<?php

/**
 * FORCECPF Local
 *
 * @package    local_forcecpf
 * @copyright  2017 FAMASA
 * @license    Commercial
 */


defined('MOODLE_INTERNAL') || die();

$observers = array(

    array(
        'eventname' => 'core\event\user_loggedin',
        'callback' => '\local_forcecpf\forcecpf::init',
    ),

    array(
        'eventname' => 'core\event\dashboard_viewed',
        'callback' => '\local_forcecpf\forcecpf::init',
    ),

    array(
        'eventname' => 'core\event\course_viewed',
        'callback' => '\local_forcecpf\forcecpf::init',
    ),

    array(
        'eventname' => 'core\event\course_category_viewed',
        'callback' => '\local_forcecpf\forcecpf::init',
    ),

    array(
        'eventname' => 'core\event\user_profile_viewed',
        'callback' => '\local_forcecpf\forcecpf::init',
    ),
);
