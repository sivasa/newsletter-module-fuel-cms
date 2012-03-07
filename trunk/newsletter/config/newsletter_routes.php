<?

$newsletter_controllers = array('subscribers','drafts','historic');

foreach($newsletter_controllers as $c){
	$route[FUEL_ROUTE.'newsletter/'.$c] = FUEL_FOLDER.'/module';
	$route[FUEL_ROUTE.'newsletter/'.$c.'/(.*)'] = FUEL_FOLDER.'/module/$1';
}


$route[FUEL_ROUTE.'newsletter/settings'] = NEWSLETTER_FOLDER.'/settings';
$route[FUEL_ROUTE.'newsletter/send'] = NEWSLETTER_FOLDER.'/send';
$route[FUEL_ROUTE.'newsletter/help'] = NEWSLETTER_FOLDER.'/help';

