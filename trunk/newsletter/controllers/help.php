<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class Help extends Fuel_base_controller {
	public $view_location = 'newsletter';
	public $nav_selected = 'newsletter/help';

	
	function __construct(){
		parent::__construct();
		$this->config->module_load('newsletter', 'newsletter');
	}
	
	function index(){	
		$vars = array();
		$this->_render('help', $vars);
	}
}