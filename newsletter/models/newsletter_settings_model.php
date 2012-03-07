<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');

class Newsletter_settings_model extends Base_module_model {

	function __construct(){
		parent::__construct('fuel_newsletter_settings', NEWSLETTER_FOLDER); 
	}
	
	
	
	public function get_settings(){
		$answer = $this->db	->limit('1')
							->order_by('date_added','asc')
							->get($this->table_name)->result_array();
		$res=array();
		if(count($answer) == '1'){
			$res = $answer['0'];
		}
		return $res;
	}

}

