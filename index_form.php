<?php

/**
 * FORCECPF Local
 *
 * @package    local_forcecpf
 * @copyright  2017 FAMASA
 * @license    Commercial
 */

require_once($CFG->libdir.'/formslib.php');

class local_forcecpf_index_form extends moodleform {

    protected function definition() {
        global $COURSE, $USER;

        $mform = $this->_form;

        $mform->addElement('text', 'cpf', get_string('cpf', 'local_forcecpf'), ['maxlength' => 11]);
        $mform->setType('cpf', PARAM_TEXT);
        $mform->addRule('cpf', get_string('onlynumbers', 'local_forcecpf'), 'minlength', 11, 'client');
        $mform->addRule('cpf', get_string('onlynumbers', 'local_forcecpf'), 'numeric', null, 'client');
        $mform->addRule('cpf', get_string('onlynumbers', 'local_forcecpf'), 'nopunctuation', null, 'client');

        $this->add_action_buttons(false, get_string('update'));
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!local_forcecpf\forcecpf::validate_cpf($data['cpf'])) {
            $errors['cpf'] = get_string('invalidcpf', 'local_forcecpf');
        }

        return $errors;
    }

}
