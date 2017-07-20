<?php

/**
 * FORCECPF Local
 *
 * @package    local_forcecpf
 * @copyright  2017 FAMASA
 * @license    Commercial
 */

namespace local_forcecpf;

class forcecpf
{
    public static function init()
    {
        global $PAGE, $USER;

        if (!$USER->id) {
            return;
        }

        if (is_siteadmin()) {
            return;
        }

        $context = \context_system::instance();
        foreach (get_user_roles($context, $USER->id) as $role) {
            if ($role->roleid < 3) {
                return;
            }
        }

        if (!self::validate_cpf($USER->username)) {
            if (self::validate_cpf($USER->idnumber)) {
                self::update($USER->idnumber);
            } else {
                if ($PAGE->state)
                    echo \html_writer::script('window.location.replace("http://localhost/mooc/moodle/local/forcecpf/index.php");');
                else
                    redirect(new \moodle_url('/local/forcecpf/index.php'));
            }
        }
    }

    public static function validate_cpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        if (strlen($cpf) != 11)
            return false;
        if (preg_match('/(\d)\1{10}/', $cpf))
            return false;
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++)
                $d += $cpf{$c} * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d)
                return false;
        }
        return true;
    }

    public static function update($data)
    {
        global $CFG, $USER;

        if (is_object($data)) {
            $value = $data->cpf;
        } else {
            $value = $data;
        }

        if (self::validate_cpf($value)) {
            if (\core_user::get_user_by_username($value)) {
                return false;
            }
            $user = \core_user::get_user($USER->id);
            $user->username = str_replace('-', '', str_replace('.', '', $value));
            require_once($CFG->dirroot . '/user/lib.php');
            user_update_user($user, false, true);
            return true;
        }

        return false;
    }

}
