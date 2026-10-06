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
 * lib.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Adds the mass enrolment page to the course navigation.
 *
 * @param navigation_node $navigation Course navigation node.
 * @param stdClass $course Course record.
 * @param context_course $context Course context.
 * @return void
 */
function local_massmailenrol_extend_navigation_course(
    navigation_node $navigation,
    stdClass $course,
    context_course $context
): void {
    if (
        !has_capability("local/massmailenrol:enrol", $context) ||
        !has_capability("enrol/manual:enrol", $context)
    ) {
        return;
    }

    $url = new moodle_url("/local/massmailenrol/", ["id" => $course->id]);
    $navigation->add(
        get_string("navigationlink", "local_massmailenrol"),
        $url,
        navigation_node::TYPE_CUSTOM,
        null,
        "local_massmailenrol"
    );
}
