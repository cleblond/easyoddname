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
 * Defines the editing form for the easyoddname question type.
 *
 * @package    qtype
 * @subpackage easyoddname
 * @copyright  2014 onwards Carl LeBlond 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');

class qtype_easyoddname_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
        global $PAGE, $CFG, $question, $DB;
        $PAGE->requires->js('/question/type/easyoddname/easyoddname_script.js');
        $PAGE->requires->css('/question/type/easyoddname/styles.css');
        if (isset($question->id)) {
                $record = $DB->get_record('question_easyoddname', array('question' => $question->id ));
        }
        $mform->addElement('static', 'answersinstruct',
        get_string('correctanswers', 'qtype_easyoddname'),
        get_string('filloutoneanswer', 'qtype_easyoddname'));
        $mform->closeHeaderBefore('answersinstruct');
        $temp = file_get_contents('type/easyoddname/dragable.html');
        $temp = str_replace("slot", "", $temp);
        $easyoddnamebuildstring = $temp;

                $mform->addElement('html', $easyoddnamebuildstring);

                        $jsmodule = array(
                            'name'     => 'qtype_easyoddname',
                            'fullpath' => '/question/type/easyoddname/easyoddname_script.js',
                            'requires' => array(),
                            'strings' => array(
                                array('enablejava', 'qtype_easyoddname')
                            )
                        );

        $htmlid = 1;
        $module = array('name' => 'easyoddname',
        'fullpath' => '/question/type/easyoddname/module.js', 'requires' => array('yui2-treeview'));

        $url = $CFG->wwwroot . '/question/type/easyoddname/template_update.php?numofstereo=';
        $PAGE->requires->js_init_call('M.qtype_easyoddname.dragndrop', array($url, $htmlid),
                                      true,
                                      $jsmodule);

        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_easyoddname', '{no}'),
                question_bank::fraction_options());
        $this->add_interactive_settings();
        $PAGE->requires->js_init_call('M.qtype_easyoddname.init_getanswerstring', array($CFG->version));
    }

    protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
        $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
        $repeatedoptions, $answersoption);
        $scriptattrs = 'class = id_insert';
        $insertbutton = $mform->createElement('button', 'insert', get_string('insertfromeditor',
        'qtype_easyoddname'), $scriptattrs);

        array_splice($repeated, 2, 0, array($insertbutton));

        return $repeated;
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        return $question;
    }

    public function qtype() {
        return 'easyoddname';
    }
}
