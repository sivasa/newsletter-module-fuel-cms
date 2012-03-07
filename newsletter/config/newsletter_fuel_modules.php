<?php

$config['modules']['newsletter_subscribers'] = array(
	'module_name' => lang('module_newsletter_manage_subscribers'),
	'module_uri' => 'newsletter/subscribers',
	'model_name' => 'newsletter_subscribers_model',
	'model_location' => 'newsletter',
	'display_field' => 'name',
	'permission' => 'newsletter/subscribers',
	'archivable' => TRUE,
	'table_actions' =>	array('edit','delete'),
	'instructions' => ' ',
	'item_actions' =>	array('save','delete','create'),
	'configuration' => array('newsletter' => 'newsletter'),
	'nav_selected' => 'newsletter/subscribers',
);

$config['modules']['newsletter_drafts'] = array(
	'module_name' => lang('module_newsletter_drafts'),
	'module_uri' => 'newsletter/drafts',
	'model_name' => 'newsletter_drafts_model',
	'model_location' => 'newsletter',
	'permission' => 'newsletter/drafts',
	'archivable' => TRUE,
	'display_field' => 'title',
	'instructions' => ' ',
	'table_actions' =>	array('edit','delete'),
	'item_actions' =>	array('save','delete','create'),
	'list_actions' =>	array('newsletter/send' => 'Envoyer une newsletter'),
	'configuration' => array('newsletter' => 'newsletter'),
	'nav_selected' => 'newsletter/drafts'
);

$config['modules']['newsletter_historic'] = array(
	'module_name' => lang('module_newsletter_historic'),
	'module_uri' => 'newsletter/historic',
	'model_name' => 'newsletter_historic_model',
	'model_location' => 'newsletter',
	'display_field' => 'title',
	'instructions' => ' ',
	'permission' => 'newsletter/historic',
	'archivable' => TRUE,
	'table_actions' =>	array('edit','delete'),
	'item_actions' =>	array('save','delete'),
	'configuration' => array('newsletter' => 'newsletter'),
	'nav_selected' => 'newsletter/historic'
);