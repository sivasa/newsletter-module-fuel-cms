<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Newsletter_subscribers_model extends Base_module_model {
 
    function __construct(){
        parent::__construct('fuel_newsletter_subscribers', NEWSLETTER_FOLDER);
    }
    
   	public function get_list(){
		return $this->db	->select('
								MAIL as `mail`, 
								NAME as `name`
							')
							->from($this->table_name)
							->get()->result_array();
	}    
}
 
