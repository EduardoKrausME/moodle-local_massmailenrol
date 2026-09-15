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
 * local_massmailenrol.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$string['details'] = 'Details';
$string['emails'] = 'Email addresses';
$string['emails_help'] = 'Paste addresses separated by commas, semicolons, spaces, or line breaks. Duplicate addresses are processed only once.';
$string['enrolusers'] = 'Enrol users';
$string['intro'] = 'Paste email addresses and choose the role to enrol all matching users in this course using manual enrolment.';
$string['invalidrole'] = 'Select a role that you are allowed to assign in this course.';
$string['manualenrolmentmissing'] = 'This course does not have an enabled manual enrolment instance.';
$string['manualpluginmissing'] = 'The manual enrolment plugin is not available.';
$string['massmailenrol:enrol'] = 'Enrol users in bulk by email';
$string['navigationlink'] = 'Enrol by email';
$string['noassignableroles'] = 'You do not have any assignable roles in this course.';
$string['pageheading'] = 'Mass enrolment by email';
$string['pluginname'] = 'Mass enrolment by email';
$string['privacy:metadata'] = 'The Mass enrolment by email plugin does not store personal data of its own.';
$string['resultheading'] = 'Processing result';
$string['role'] = 'Role';
$string['status'] = 'Status';
$string['statusalready'] = 'Already enrolled';
$string['statusenrolled'] = 'Enrolled';
$string['statusfailed'] = 'Failed';
$string['statusinvalid'] = 'Invalid email';
$string['statusnotfound'] = 'Not found';
$string['statussuspended'] = 'Suspended user';
