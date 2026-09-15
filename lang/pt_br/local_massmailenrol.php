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

$string['details'] = 'Detalhes';
$string['emails'] = 'Endereços de e-mail';
$string['emails_help'] = 'Cole os endereços separados por vírgulas, ponto e vírgula, espaços ou quebras de linha. Endereços repetidos são processados apenas uma vez.';
$string['enrolusers'] = 'Inscrever usuários';
$string['intro'] = 'Cole os endereços de e-mail e escolha o papel. Todos os usuários encontrados serão matriculados neste curso pelo método de inscrição manual.';
$string['invalidrole'] = 'Selecione um papel que você tenha permissão para atribuir neste curso.';
$string['manualenrolmentmissing'] = 'Este curso não possui uma instância ativa de inscrição manual.';
$string['manualpluginmissing'] = 'O plugin de inscrição manual não está disponível.';
$string['massmailenrol:enrol'] = 'Inscrever usuários em massa por e-mail';
$string['navigationlink'] = 'Inscrever por e-mail';
$string['noassignableroles'] = 'Você não possui papéis que possam ser atribuídos neste curso.';
$string['pageheading'] = 'Inscrição em massa por e-mail';
$string['pluginname'] = 'Inscrição em massa por e-mail';
$string['privacy:metadata'] = 'O plugin Inscrição em massa por e-mail não armazena dados pessoais próprios.';
$string['resultheading'] = 'Resultado do processamento';
$string['role'] = 'Papel';
$string['status'] = 'Situação';
$string['statusalready'] = 'Já inscritos';
$string['statusenrolled'] = 'Inscritos';
$string['statusfailed'] = 'Falha';
$string['statusinvalid'] = 'E-mail inválido';
$string['statusnotfound'] = 'Não encontrados';
$string['statussuspended'] = 'Usuário suspenso';
