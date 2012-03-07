<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class Send extends Fuel_base_controller {
	public $view_location = 'newsletter';
	public $nav_selected = 'newsletter/send';
	
	private $_data_sess;
	private $notif = false;
	
	function __construct(){
		parent::__construct();
		$this->config->module_load('newsletter', 'newsletter');
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_send_model');
		if(isset($_POST['cancel']) ){
			$this->_cancel();
			
		}
		
		if (!empty($_POST['select_draft'])){
			$this->_data_sess = array(
				'draft' => $_POST['select_draft']['draft'],
				'previous_step'=>$_POST['select_draft']['previous_step']
			);
			$this->session->set_userdata('newsletter_send', $this->_data_sess);
		}
		elseif(!empty($_POST['preview'])){
			$this->_data_sess = $this->session->userdata('newsletter_send');
			if(isset($_POST[lang('module_newsletter_send')])){
				$this->_send();
			}
		}
		$this->_data_sess = $this->session->userdata('newsletter_send');
	}
	
	function index(){
		if(empty($this->_data_sess)){
			$this->_select_draft();
		}
		elseif($this->_data_sess['previous_step'] =="select_draft"){
			$this->_preview();
		}
	}
	
	private function _cancel(){
		$this->_sess_destroy();
		$this->notif = '<div class="warning ico ico_warn" style="background-color: rgb(255, 255, 153); ">'.lang('module_newsletter_process_denied').'</div>';
	}
	
	private function _sess_destroy(){
		$this->session->unset_userdata('newsletter_send');
	}
	
	private function _send(){
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_drafts_model');
		$draft = $this->newsletter_drafts_model->get_draft($this->_data_sess['draft']);
	
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_subscribers_model');
		$list_mail = $this->newsletter_subscribers_model->get_list();
		
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_settings_model');
		$settings = $this->newsletter_settings_model->get_settings();
		

		$draft['nb_mail_sent'] = 0;
		if(!empty($list_mail)){
			foreach($list_mail as $subscriber){
				$config['mailtype'] = 'html';
				$config['useragent'] = $settings['user_agent'];
				$this->email->initialize($config);
				$this->email->subject($draft['title']);
				$this->email->to($subscriber['mail']);
				$this->email->message($draft['content']);
		   		$this->email->from($settings['from_mail'],$settings['from_mail']);
		   		if($this->email->send()){
					$draft['nb_mail_sent'] ++;
				}
		   	}	   		
		}
		
		$this->newsletter_drafts_model->del_draft($draft['id']);
		
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_historic_model');
		$this->newsletter_historic_model->add_to_historic($draft);
		
		
		$this->notif = '<div class="success ico_success" style="background-color: rgb(220, 255, 184); ">'.lang('module_newsletter_newsletter_sent_to').' '.$draft['nb_mail_sent'].' ';
		if($draft['nb_mail_sent'] > 1)
		 	$this->notif .= lang('module_newsletter_subscribers');
		else
			$this->notif .= lang('module_newsletter_subscriber');		
		$this->notif .='.</div>';
		
		$this->_sess_destroy();
	}

	private function _select_draft(){	
		$this->load->library('form_builder');
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_drafts_model');
		$drafts = $this->newsletter_drafts_model->get_title_draft();
		
		if(count($drafts)<0){
			$vars['content'] = lang('module_newsletter_no_draft_to_send');
			$vars['button'] = lang('module_newsletter_create');
			$this->_render('send/no_draft', $vars);
		}
		else{
			$this->load->library('form_builder');
			$fields = array();
			$fields['draft'] = array();
			$fields['draft']['type'] = 'select';
			$fields['draft']['options'] = $this->newsletter_drafts_model->get_title_draft();
			$fields['draft']['label'] = lang('module_newsletter_draft');
			$fields['previous_step'] = array();
			$fields['previous_step']['type'] = 'hidden';
			$fields['previous_step']['value'] = 'select_draft';
			$this->form_builder->label_layout = 'left';
			$this->form_builder->use_form_tag = FALSE;
			$this->form_builder->set_fields($fields);
			$this->form_builder->display_errors = FALSE;
			$this->form_builder->name_array = 'select_draft';
			$this->form_builder->submit_value = lang('module_newsletter_preview');
			$vars = array();
			$vars['form'] = $this->form_builder->render();		
			$vars['cancel'] = false;
			if($this->notif != null)
				$vars['notifications'] = $this->notif;
			$this->_render('send/select_draft', $vars);
		}		
	}
	
	private function _preview(){
		$this->load->library('form_builder');
		$this->load->module_model(NEWSLETTER_FOLDER, 'newsletter_drafts_model');
		$fields = array();
		$this->load->library('form_builder');
		$fields = array();	
		$fields['previous_step'] = array();
		$fields['previous_step']['type'] = 'hidden';
		$fields['previous_step']['value'] = 'preview';
		$this->form_builder->label_layout = 'left';
		$this->form_builder->use_form_tag = FALSE;
		$this->form_builder->set_fields($fields);
		$this->form_builder->display_errors = FALSE;
		$this->form_builder->name_array = 'preview';
		$this->form_builder->submit_value = lang('module_newsletter_send');
		$vars = array();
		$vars['form'] = $this->form_builder->render();		
		$vars['preview'] = $this->newsletter_drafts_model->get_draft($this->_data_sess['draft']);
		$vars['cancel'] = true;
		
		$this->_render('send/preview', $vars);
	}
	
}