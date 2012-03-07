<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class Settings extends Fuel_base_controller {
	public $view_location = 'newsletter';
	public $nav_selected = 'newsletter/settings';
	private $_notif = "";
	
	function __construct(){
		parent::__construct();
		$this->config->module_load('newsletter', 'newsletter');
		//$this->_validate_user('newsletter/create');
	}
	
	function index(){
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_settings_model');
		
		if (!empty($_POST['settings'])){
		
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
	
			$this->form_validation->set_rules('settings[from_name]', 'from_name', 'required');
			$this->form_validation->set_rules('settings[from_mail]', 'from_mail', 'required|valid_email');
			$this->form_validation->set_rules('settings[user_agent]', 'user_agent', 'required');
	
			if ($this->form_validation->run() == FALSE){
				$fields = array("settings[from_name]","settings[from_mail]","settings[user_agent]");
				foreach($fields as $field){
					if(form_error($field) != "")
						$this->_add_notif(form_error($field));
				}
				
			}
			else{
				$settings = $_POST['settings'];
				$this->newsletter_settings_model->save($settings);
			}
		}
		$settings = $this->newsletter_settings_model->get_settings();
		
		$this->load->library('form_builder');
		$fields = array();
		
		foreach($settings as $name=>$value){
			$fields[$name] = array();
			$fields[$name]['value'] = $value;
			if($name == 'header' or $name == 'footer'){
				$fields[$name]['type'] = 'text';
			}
			if($name == 'date_added'){
				$fields[$name]['type'] = 'hidden';
			}
			
			if($name == 'from_name' or $name == 'from_mail' or $name == 'user_agent'){
				$fields[$name]['required'] = 'true';
			}
			$fields[$name]['label'] = lang('module_newsletter_'.$name);

		}	
		$this->form_builder->label_layout = 'left';
		$this->form_builder->use_form_tag = FALSE;
		$this->form_builder->set_fields($fields);
		$this->form_builder->display_errors = FALSE;
		$this->form_builder->name_array = 'settings';
		$this->form_builder->submit_value = lang('module_newsletter_save_settings');

		
		
		$vars = array();
		$vars['notifications'] ="";
		$vars['form'] = $this->form_builder->render();	
		$vars['notifications'] .= $this->_notif;	
		$this->_render('settings', $vars);
	}
	
	public function _add_notif($msg,$type='error'){
		$this->notif .= $msg;
	}

}