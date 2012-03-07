<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');

class Newsletter_historic_model extends Base_module_model {

	function __construct(){
		parent::__construct('fuel_newsletter_historic', NEWSLETTER_FOLDER);
	}
	
	function form_fields($values = array()){
		$fields = parent::form_fields();
		foreach($fields as &$f){
			$f['displayonly'] = true;
		}
		
		
		return $fields;
	}
	
	public function add_to_historic($draft){
		$data = array(
			'title' =>$draft['title'],
			'content' =>$draft['content'],
			'nb_mail_sent' => $draft['nb_mail_sent'],
		);
		$this->db->set('date_sent', 'NOW()',false);
		$this->db->set($data);
		$this->db->insert($this->table_name);
	}
}

class Newsletter_sent_model extends Base_module_record {
 
}