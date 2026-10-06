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
 * index.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . "/../../config.php");
require_once($CFG->libdir . "/formslib.php");
require_once($CFG->dirroot . "/enrol/locallib.php");

use local_massmailenrol\form\enrol_form;
use local_massmailenrol\enrolment_manager;

$courseid = required_param("id", PARAM_INT);
$course = get_course($courseid);
$context = context_course::instance($course->id);

require_login($course);
require_capability("local/massmailenrol:enrol", $context);
require_capability("enrol/manual:enrol", $context);

$PAGE->set_url(new moodle_url("/local/massmailenrol/", ["id" => $course->id]));
$PAGE->set_context($context);
$PAGE->set_course($course);
$PAGE->set_title(get_string("pluginname", "local_massmailenrol"));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->navbar->add(get_string("pluginname", "local_massmailenrol"));

$roles = get_assignable_roles($context, ROLENAME_ALIAS, false, $USER);
if (!$roles) {
    throw new moodle_exception("noassignableroles", "local_massmailenrol");
}

$defaultroleid = 0;
foreach (get_archetype_roles("student") as $studentrole) {
    if (isset($roles[$studentrole->id])) {
        $defaultroleid = (int)$studentrole->id;
        break;
    }
}
if (!$defaultroleid) {
    $defaultroleid = (int)array_key_first($roles);
}

$form = new enrol_form(null, [
    "roles" => $roles,
    "defaultroleid" => $defaultroleid,
]);

$result = null;
if ($data = $form->get_data()) {
    $manager = new enrolment_manager($course, $context);
    $result = $manager->enrol($data->emails, (int)$data->roleid);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string("pageheading", "local_massmailenrol"));
echo html_writer::tag("p", get_string("intro", "local_massmailenrol"), ["class" => "text-muted"]);

$form->display();

if ($result !== null) {
    echo $OUTPUT->heading(get_string("resultheading", "local_massmailenrol"), 3);

    $summary = html_writer::start_div("row g-3 mb-4");
    $cards = [
        ["enrolled", "success"],
        ["already", "info"],
        ["notfound", "warning"],
        ["invalid", "secondary"],
        ["duplicate", "warning"],
        ["suspended", "secondary"],
        ["failed", "danger"],
    ];

    foreach ($cards as [$key, $style]) {
        $summary .= html_writer::start_div("col-6 col-md-4 col-xl-2");
        $summary .= html_writer::start_div("border rounded p-3 h-100");
        $summary .= html_writer::div(
            (string)count($result[$key]),
            "h3 mb-1 text-{$style}"
        );
        $summary .= html_writer::div(get_string("status{$key}", "local_massmailenrol"), "small text-muted");
        $summary .= html_writer::end_div();
        $summary .= html_writer::end_div();
    }
    $summary .= html_writer::end_div();
    echo $summary;

    $table = new html_table();
    $table->head = [
        get_string("status", "local_massmailenrol"),
        get_string("name"),
        get_string("email"),
        get_string("details", "local_massmailenrol"),
    ];
    $table->attributes["class"] = "generaltable table-striped";

    $userstatuses = ["enrolled", "already", "suspended", "failed"];
    foreach ($userstatuses as $status) {
        foreach ($result[$status] as $item) {
            $detail = $item["error"] ?? "";
            $table->data[] = [
                get_string("status{$status}", "local_massmailenrol"),
                format_string($item["fullname"]),
                s($item["email"]),
                s($detail),
            ];
        }
    }

    foreach (["notfound", "invalid", "duplicate"] as $status) {
        foreach ($result[$status] as $email) {
            $table->data[] = [
                get_string("status{$status}", "local_massmailenrol"),
                "—",
                s($email),
                "",
            ];
        }
    }

    if ($table->data) {
        echo html_writer::table($table);
    }
}

echo $OUTPUT->footer();
