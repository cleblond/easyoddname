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
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * easyoddname question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');


/**
 * Calculated question type editing form definition.
 *
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_easyoddname_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
		global $PAGE, $CFG, $question, $DB, $numofstereo;
		
		$PAGE->requires->js('/question/type/easyoddname/easyoddname_script.js');
		$PAGE->requires->css('/question/type/easyoddname/styles.css');
               // $mform->addElement('hidden', 'usecase', 1);
		if(isset($question->id)){
		$record = $DB->get_record('question_easyoddname', array('question' => $question->id ));
		$numofstereo = $record->numofstereo;
		//echo $stagoreclip;
		}
		else{
		$numofstereo = 1;
		}
	//echo required_param('id',0);
	
	//echo $question->id;
	//var_dump($question);
	//echo required_param('stagoreclip', PARAM_INT);

        
 $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_easyoddname'),
                get_string('filloutoneanswer', 'qtype_easyoddname'));
        $mform->closeHeaderBefore('answersinstruct');


/*
 $menu = array(
            get_string('staggered', 'qtype_easyoddname'),
            get_string('eclipsed', 'qtype_easyoddname')	    
        );
        $mform->addElement('select', 'stagoreclip',
                get_string('casestagoreclip', 'qtype_easyoddname'), $menu);
*/




       
		
//		$appleturl = new moodle_url('/question/type/easyoddname/easyoddname/easyoddname.jar');


		//get the html in the easyoddnamelib.php to build the applet
//	    $easyoddnamebuildstring = "\n<applet code=\"easyoddname.class\" name=\"easyoddname\" id=\"easyoddname\" archive =\"$appleturl\" width=\"460\" height=\"335\">" .
//	  "\n<param name=\"options\" value=\"" . $CFG->qtype_easyoddname_options . "\" />" .
//      "\n" . get_string('javaneeded', 'qtype_easyoddname', '<a href="http://www.java.com">Java.com</a>') .
//	  "\n</applet>";
	//echo $data['stagoreclip'];


//$easyoddnamebuildstring=file_get_contents('type/easyoddname/edit_fischer1.html');

//$temp=$temp = str_replace("slot", $qa->get_slot(), $temp);

$temp=file_get_contents('type/easyoddname/dragable.html');
$temp = str_replace("slot", "", $temp);

$easyoddnamebuildstring = $temp;



//echo "here".$easyoddnamebuildstring;

	//echo $mform->get_data();




        //output the marvin applet
        //$mform->addElement('html', html_writer::start_tag('div', array('style'=>'width:650px;')));
		//$mform->addElement('html', html_writer::start_tag('div', array('style'=>'float: right;font-style: italic ;')));
		//$mform->addElement('html', html_writer::start_tag('small'));
		//$easyoddnamehomeurl = 'http://www.easyochem.com';
		//$mform->addElement('html', html_writer::link($easyoddnamehomeurl, get_string('easyoddnameeditor', 'qtype_easyoddname')));
		//$mform->addElement('html', html_writer::empty_tag('br'));
		//$mform->addElement('html', html_writer::tag('span', get_string('author', 'qtype_easyoddname'), array('class'=>'easyoddnameauthor')));
		//$mform->addElement('html', html_writer::end_tag('small'));
		//$mform->addElement('html', html_writer::end_tag('div'));


//		$mform->addElement('html', html_writer::start_tag('div', array('id'=>'fischer_template', 'width'=>'650px')));
		$mform->addElement('html',$easyoddnamebuildstring);
//		$mform->addElement('html', html_writer::end_tag('div'));



		//$mform->addElement('html', html_writer::end_tag('div'));

			$jsmodule = array(
			    'name'     => 'qtype_easyoddname',
			    'fullpath' => '/question/type/easyoddname/easyoddname_script.js',
			    'requires' => array(),
			    'strings' => array(
				array('enablejava', 'qtype_easyoddname')
			    )
			);




	    $htmlid=1;
 	    $module = array('name'=>'easyoddname', 'fullpath'=>'/question/type/easyoddname/module.js', 'requires'=>array('yui2-treeview'));
	    //$htmlid = 'private_files_tree_'.uniqid();
            //$url = 'http://localhost/eolms/question/type/easyoddname/template_update.php?htmlid='+$htmlid;
		$url = $CFG->wwwroot . '/question/type/easyoddname/template_update.php?numofstereo=';
            //$this->page->requires->js_init_call('M.block_ejsapp_file_browser.init_tree', array(false, $htmlid));
           // $PAGE->requires->js_init_call('M.qtype_easyoddname.init_reload', array($url, $htmlid),		
           //                           true,
           //                           $jsmodule);
	   $PAGE->requires->js_init_call('M.qtype_easyoddname.dragndrop', array($url, $htmlid),		
                                      true,
                                      $jsmodule);
           // $html = '<div id="'.$htmlid.'">';
            //$html .= $this->htmllize_tree($tree, $tree->dir);
            //$html .= '</div>';









///crl add structure to page




//	$PAGE->requires->js_init_call('M.qtype_easyoddname.insert_structure_into_applet',
//                                      array($numofstereo),		
//                                      true,
//                                      $jsmodule);




        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_easyoddname', '{no}'),
                question_bank::fraction_options());

        $this->add_interactive_settings();
    }
	
	protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
		global $numofstereo;
        $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
                $repeatedoptions, $answersoption);
		
		//construct the insert button
//crl mrv		$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'cxsmiles:u\')"';
		//echo "num".$numofstereo;
		$scriptattrs = 'onClick = "getSmilesEdit(this.name)"';


        $insert_button = $mform->createElement('button','insert',get_string('insertfromeditor', 'qtype_easyoddname'),$scriptattrs);
        array_splice($repeated, 2, 0, array($insert_button));

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
