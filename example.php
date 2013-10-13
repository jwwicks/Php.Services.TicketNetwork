<?php 

/**
 * This isn't really used any more unless you intend
 * to run the functions included in the TicketNetwork supplied kit
 * genericLib.php and tnsample.php
 */
if(!defined('MODE')){
	DEFINE('MODE', 'test');
}

if(!class_exists('TicketNetworkFactory')){
	require_once('ticketnetwork.class.php');
}

$factory = new TicketNetworkFactory();
/**
 * Set the mode to production
 * Changes the endpoint for the Webservice calls
 */
//$factory->config(array('mode'=>'production'));

/**
 * use the State object to call 
 */
//$stateObj = $factory->create('state', $factory->options());
//$stateObj->set(array('countryID' => UNITED_STATES), 'data');
//$states = $stateObj->send('get', array('countryID' => UNITED_STATES))->results();

//$countryObj = $factory->create('country', $factory->options());
//$countries = $countryObj->send('get')->results();
//$country = $countryObj->send('get', array('countryID'=>UNITED_STATES))->results();

$categoryObj = $factory->create('category', $factory->options());
$categories = $categoryObj->send('get')->results();

pr($categories);

//$result = $categoryObj->has('cfl', 'map');
//$categories = $categoryObj->send('get', array('method'=>'GetSublevelCategories', 'parentCategoryID'=>SPORTS))->results();
//$categories = $categoryObj->send('get', array('method'=>'GetSublevelCategories', 'parentCategoryID'=>SPORTS, 'childCategoryID'=>FOOTBALL))->results();
//$categories = $categoryObj->send('get', array('countryID'=>UNITED_STATES, 'parentCategoryID'=>THEATER))->results();

//$eventObj = $factory->create('event', $factory->options());
//$events = $eventObj->send('get', array('parentCategoryID'=>SPORTS, 'grandchildCategoryID'=>MLB_PRO_GRANDCHILD, 'numberOfEvents'=>50))->results();
//$event = $eventObj->send('get', array('eventID'=>2044875))->results();

//$ticketObj = $factory->create('ticket', $factory->options());
//$tickets = $ticketObj->send('get', array('eventID'=>2096016))->results();

//$performerObj = $factory->create('performer');

//$top_inventory = $performerObj->send('get', array('method'=>'GetHighInventoryPerformers', 'parentCategoryID'=>SPORTS, 'numReturned'=>12))->results();
//$top_sports_inventory = $performerObj->send('get', array('method'=>'GetHighInventoryPerformers', 'numReturned'=> 15, 'parentCategoryID'=>SPORTS))->results();
//$top_sports_sales = $performerObj->send('get', array('method'=>'GetHighSalesPerformers', 'grandchildCategoryID'=>MLB_PRO_GRANDCHILD, 'numReturned'=>5))->results();
//$top_inventory = $performerObj->send('get', array('method'=>'GetHighInventoryPerformers', 'parentCategoryID'=>CONCERTS, 'numReturned'=>5))->results();
//$top = $performerObj->send('get', array('method'=>'GetHighSalesPerformers', 'parentCategoryID'=>CONCERTS, 'childCategoryID'=>RAP_AND_HIP_HOP))->results();

//$term = 'wicked';
//$method = 'search';
//$params = array('method'=>'SearchEvents', 'searchTerms'=>"{$term}");
//$params['whereClause'] = 'Date >= DateTime("'.date('m-d-Y').'")';
//$factory = new TicketNetworkFactory();
//$eventObj = $factory->create('event', $factory->options());
//$events = $eventObj->send($method, $params)->results();

/*
$start = new DateTime("this friday");
$end = new DateTime("next monday");
$params = array(
	'method'=> 'GetEvents',
	'beginDate' => $start->format('m-d-Y'),
	'endDate' => $end->format('m-d-Y'),
	'numberOfEvents' => 250
);
$method = 'get';
$factory = new TicketNetworkFactory();
$eventObj = $factory->create('event', $factory->options());
			
$events = $eventObj->send($method, $params)->results();
*/

/*
$params = array('method'=>'GetVenueConfigurations');
$factory = new TicketNetworkFactory();
$venueObj = $factory->create('venue', $factory->options());

if($venueObj->has($params['VenueConfigurationID'], 'map')){
	$ticketUtilsMapID = $venueObj->chart($params['VenueConfigurationID']);
}
*/

/**
 * For debugging
 */
function pr($data, $prefix="", $postfix=""){
	echo "<pre style=\"background:#000;color:#fff;font-size:12px;padding:10px;\">";
	echo $prefix."<br />\n";
	htmlspecialchars_decode(print_r($data));
	echo $postfix."<br />\n";
	echo "</pre><br />\n";
}