<?php

/**
 * FORCECPF Local
 *
 * @package    local_forcecpf
 * @copyright  2017 FAMASA
 * @license    Commercial
 */

require_once '../../config.php';
require_once 'index_form.php';

require_login();
$site = get_site();

$context = \context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/forcecpf/index.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_title($site->shortname);
$PAGE->set_heading($site->shortname);

$form = new local_forcecpf_index_form();

if ($formdata = $form->get_data()) {
    $forcecpf = new \local_forcecpf\forcecpf();
    if ($forcecpf->update($formdata)) {
        redirect(new moodle_url('/'), get_string('eventuserupdated'), 10);
    } else {
        redirect(new moodle_url('/local/forcecpf/index.php'), get_string('error', 'moodle'), 10);
    }
}

if (get_config('local_forcecpf', 'custommessage')) {
    $message = get_config('local_forcecpf', 'custommessage');
} else {
    $message = get_string('message', 'local_forcecpf');
}

echo $OUTPUT->header();
echo html_writer::div($message, 'card card-block');
echo $form->display();
echo $OUTPUT->footer();
