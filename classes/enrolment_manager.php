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
 * enrolment_manager.php
 *
 * @package   local_massmailenrol
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_massmailenrol;

use context_course;
use core_text;
use stdClass;
use Throwable;

/**
 * Class enrolment_manager.
 */
class enrolment_manager {
    /**
     * Property course.
     *
     * @var stdClass
     */
    private stdClass $course;
    /**
     * Property context.
     *
     * @var context_course
     */
    private context_course $context;

    /**
     * Method __construct.
     *
     * @param stdClass $course Parameter course.
     * @param context_course $context Parameter context.
     */
    public function __construct(stdClass $course, context_course $context) {
        $this->course = $course;
        $this->context = $context;
    }

    /**
     * Method parse_emails.
     *
     * @param string $input Parameter input.
     * @return array Return value.
     */
    public static function parse_emails(string $input): array {
        $parts = preg_split('/[\s,;]+/u', trim($input), -1, PREG_SPLIT_NO_EMPTY);
        $emails = [];

        foreach ($parts ?: [] as $email) {
            $email = core_text::strtolower(trim($email));
            if ($email === "") {
                continue;
            }
            $emails[$email] = $email;
        }

        return array_values($emails);
    }

    /**
     * Method enrol.
     *
     * @param string $input Parameter input.
     * @param int $roleid Parameter roleid.
     * @return array Return value.
     */
    public function enrol(string $input, int $roleid): array {
        global $DB;

        require_capability("enrol/manual:enrol", $this->context);

        $manualinstance = $this->get_manual_instance();
        if (!$manualinstance) {
            throw new \moodle_exception("manualenrolmentmissing", "local_massmailenrol");
        }

        $plugin = enrol_get_plugin("manual");
        if (!$plugin) {
            throw new \moodle_exception("manualpluginmissing", "local_massmailenrol");
        }
        if (!$plugin->allow_enrol($manualinstance)) {
            throw new \moodle_exception("manualenrolmentnotallowed", "local_massmailenrol");
        }

        $result = [
            "enrolled" => [],
            "already" => [],
            "notfound" => [],
            "invalid" => [],
            "duplicate" => [],
            "suspended" => [],
            "failed" => [],
        ];

        $validemails = [];
        foreach (self::parse_emails($input) as $email) {
            if (!validate_email($email)) {
                $result["invalid"][] = $email;
                continue;
            }
            $validemails[] = $email;
        }

        $usersbyemail = [];
        foreach (array_chunk($validemails, 500) as $chunk) {
            [$insql, $params] = $DB->get_in_or_equal($chunk, SQL_PARAMS_NAMED, "email");
            $sql = "SELECT id, email, firstname, lastname, suspended, deleted
                      FROM {user}
                     WHERE deleted = 0
                       AND LOWER(email) {$insql}";

            foreach ($DB->get_records_sql($sql, $params) as $user) {
                $email = core_text::strtolower($user->email);
                if (!isset($usersbyemail[$email])) {
                    $usersbyemail[$email] = [];
                }
                $usersbyemail[$email][] = $user;
            }
        }

        foreach ($validemails as $email) {
            if (!isset($usersbyemail[$email])) {
                $result["notfound"][] = $email;
                continue;
            }

            if (count($usersbyemail[$email]) > 1) {
                $result["duplicate"][] = $email;
                continue;
            }

            $user = $usersbyemail[$email][0];
            $item = $this->user_item($user);

            if (!empty($user->suspended)) {
                $result["suspended"][] = $item;
                continue;
            }

            if (is_enrolled($this->context, $user)) {
                $result["already"][] = $item;
                continue;
            }

            $timestart = 0;
            $timeend = 0;
            if (!empty($manualinstance->enrolperiod)) {
                $timestart = time();
                $timeend = $timestart + (int)$manualinstance->enrolperiod;
            }

            try {
                $plugin->enrol_user(
                    $manualinstance,
                    $user->id,
                    $roleid,
                    $timestart,
                    $timeend,
                    ENROL_USER_ACTIVE
                );
                $result["enrolled"][] = $item;
            } catch (Throwable $exception) {
                $item["error"] = $exception->getMessage();
                $result["failed"][] = $item;
            }
        }

        return $result;
    }

    /**
     * Method get_manual_instance.
     *
     * @return ?stdClass Return value.
     */
    private function get_manual_instance(): ?stdClass {
        foreach (enrol_get_instances($this->course->id, true) as $instance) {
            if ($instance->enrol === "manual") {
                return $instance;
            }
        }

        return null;
    }

    /**
     * Method user_item.
     *
     * @param stdClass $user Parameter user.
     * @return array Return value.
     */
    private function user_item(stdClass $user): array {
        return [
            "id" => (int)$user->id,
            "fullname" => fullname($user),
            "email" => $user->email,
        ];
    }
}
