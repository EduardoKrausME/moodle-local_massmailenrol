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
 * enrolment_manager_test.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_massmailenrol;

use local_massmailenrol\enrolment_manager;

/**
 * enrolment_manager_test
 *
 * @covers \local_massmailenrol\enrolment_manager
 */
final class enrolment_manager_test extends \advanced_testcase {
    /**
     * Method test_parse_emails_accepts_common_separators_and_removes_duplicates.
     *
     * @return void Return value.
     */
    public function test_parse_emails_accepts_common_separators_and_removes_duplicates(): void {
        $input = "ONE@example.com, two@example.com\nthree@example.com; one@example.com";

        $this->assertSame(
            ["one@example.com", "two@example.com", "three@example.com"],
            enrolment_manager::parse_emails($input)
        );
    }
}
