# local_massmailenrol

Local Moodle plugin for enrolling existing users in a course from a pasted list of email addresses.

## Features

- Moodle `moodleform` form.
- Accepts comma, semicolon, whitespace and line-break separators.
- Removes duplicate addresses.
- Uses Moodle's manual enrolment API.
- Lets the current user choose only roles they are allowed to assign.
- Shows enrolled, already enrolled, not found, invalid, suspended and failed entries.
- Adds a link to the course navigation for users with the plugin capability.
- Stores no plugin-specific personal data.

## Installation

Copy the directory to:

`local/massmailenrol`

Then complete the Moodle plugin installation from Site administration.

The course must have an enabled **Manual enrolments** instance.
