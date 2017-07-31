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

if (local_forcecpf\forcecpf::validate_cpf($USER->username)) {
    redirect(new \moodle_url('/'));
}

$context = \context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/forcecpf/index.php');
$PAGE->set_pagelayout('standard');
$PAGE->set_title($site->shortname);
$PAGE->set_heading($site->shortname);

$form = new local_forcecpf_index_form();

if (get_config('local_forcecpf', 'custommessage')) {
    $message = get_config('local_forcecpf', 'custommessage');
} else {
    $message = get_string('message', 'local_forcecpf');
}

if (get_config('local_forcecpf', 'errormessage')) {
    $errormessage = get_config('local_forcecpf', 'errormessage');
} else {
    $errormessage = get_string('messageerror', 'local_forcecpf');
}

if (get_config('local_forcecpf', 'successmessage')) {
    $successmessage = get_config('local_forcecpf', 'successmessage');
} else {
    $successmessage = get_string('messagesuccess', 'local_forcecpf');
}

$success = false;
if ($formdata = $form->get_data()) {
    $forcecpf = new \local_forcecpf\forcecpf();
    $success = $forcecpf->update($formdata);
    if (!$success) {
        redirect(new moodle_url('/login/logout.php', array('sesskey'=>sesskey(),'loginpage'=>1)), $errormessage, 10, \core\output\notification::NOTIFY_ERROR);
    }
}

echo $OUTPUT->header();
if ($success) {
    echo html_writer::div($successmessage, 'card card-block');
    echo $OUTPUT->single_button(new moodle_url('/'), get_string('continue'), 'get');
} else {
    echo html_writer::div($message, 'card card-block');
    echo $form->display();
}
echo $OUTPUT->footer();
