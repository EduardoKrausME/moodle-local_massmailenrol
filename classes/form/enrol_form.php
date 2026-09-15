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
 * enrol_form.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_massmailenrol\form;

use moodleform;

/**
 * Class enrol_form.
 */
class enrol_form extends moodleform {
    /**
     * Method definition.
     *
     * @return void Return value.
     */
    protected function definition(): void {
        $mform = $this->_form;
        $roles = $this->_customdata["roles"] ?? [];
        $defaultroleid = $this->_customdata["defaultroleid"] ?? 0;

        $mform->addElement(
            "textarea",
            "emails",
            get_string("emails", "local_massmailenrol"),
            ["rows" => 12, "class" => "w-100"]
        );
        $mform->setType("emails", PARAM_RAW_TRIMMED);
        $mform->addRule("emails", get_string("required"), "required", null, "client");
        $mform->addHelpButton("emails", "emails", "local_massmailenrol");

        $mform->addElement(
            "select",
            "roleid",
            get_string("role", "local_massmailenrol"),
            $roles
        );
        $mform->setType("roleid", PARAM_INT);
        $mform->addRule("roleid", get_string("required"), "required", null, "client");

        if ($defaultroleid && array_key_exists($defaultroleid, $roles)) {
            $mform->setDefault("roleid", $defaultroleid);
        }

        $this->add_action_buttons(false, get_string("enrolusers", "local_massmailenrol"));
    }

    /**
     * Method validation.
     *
     * @param mixed $data Parameter data.
     * @param mixed $files Parameter files.
     * @return array Return value.
     */
    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        $roles = $this->_customdata["roles"] ?? [];

        if (!isset($roles[(int)($data["roleid"] ?? 0)])) {
            $errors["roleid"] = get_string("invalidrole", "local_massmailenrol");
        }

        return $errors;
    }
}
