<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Newsletter_drafts_model extends Base_module_model {
 
    function __construct(){
        parent::__construct('fuel_newsletter_drafts', NEWSLETTER_FOLDER);
    }
    
    function form_fields($values = array()){
		$fields = parent::form_fields();
		$fields['last_modified']['type'] = 'hidden';
		$fields['date_added']['type'] = 'hidden';
		return $fields;
	}
	
	function get_title_draft(){
		$res = false;
		$answer = $this->db	->select('id,title,last_modified')
							->from($this->table_name)
							->order_by('last_modified','desc')
							->get()->result_array();
							
		if( ! empty($answer)){
			foreach($answer as $a){
				$res[$a['id']] = $a['last_modified'] . ' | '. $a['title'];
			}
		}
		return $res;
	}
	
	public function get_draft($id){
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_settings_model');
		$settings = $this->newsletter_settings_model->get_settings();
		$res = false;
		$answer = $this->db	->select("id,title,content")
							->from($this->table_name)
							->where('id',$id)
							->get()->result_array();
							
		if( ! empty($answer) and count($answer) == '1'){
			$res = $answer['0'];
		}
		$res['content'] = $settings['header'].$res['content'].$settings['footer'];
		$res['title'] = $settings['prefix_title'].$res['title'];
		return $res;	
	}
	
	public function del_draft($id){
		$res = false;
		$this->db	->where('id', $id)
					->limit('1')
					->delete($this->table_name);
		return $res;
	}
	
	

	

	
}
 