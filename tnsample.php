<?php
	if(!defined('MODE')){
		DEFINE('MODE', 'test');
	}

	require_once ('genericLib.php');
	$events = "";
	function displaySearchEventsDetailsBasicFormating() {
		global $events;
		$paramSearchEvents = array('websiteConfigID' => WEB_CONF_ID, 'searchTerms' => 'wicked');
		$events = searchEventsDetailsBasicFormating($paramSearchEvents);
	}
	//displaySearchEventsDetailsBasicFormating();
	function displaySearchEventsDetailsComma() {
		global $events;
		$paramSearchEvents = array('websiteConfigID' => WEB_CONF_ID, 'searchTerms' => 'wicked');
		$events = searchEventsDetailsComma($paramSearchEvents);
	}
	//displaySearchEventsDetailsComma();
	function displaySearchEventsDetailsArray() {
		global $events;
		$paramSearchEvents = array('websiteConfigID' => WEB_CONF_ID, 'searchTerms' => 'wicked', 'whereClause' => 'Date >= DateTime("'.date('m-d-Y').'")');
		foreach (searchEventsDetailsArray($paramSearchEvents) as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v;
			}
			$events .= "<br>";
		};
	}
	//displaySearchEventsDetailsArray();
	
	function displayGetEventsDetailsBasicFormating() {
		global $events;
		$paramGetEvents = array(
		'websiteConfigID' => WEB_CONF_ID,
		'numberOfEvents'=>null, 
		'eventID' => null, 
		'eventName' => 'wicked', 
		'eventDate' => null, 
		'beginDate'=>null, 
		'endDate' => null, 
		'venueID'=>null, 
		'venueName' => '', 
		'stateProvDesc' => '', 
		'stateID'=>null, 'cityZip' => '', 
		'nearZip' => '', 
		'parentCategoryID' => null, 
		'childCategoryID' => null, 
		'grandchildCategoryID' => null, 
		'performerID' => null, 
		'performerName' => '', 
		'noPerformers' => null, 
		'lowPrice' => null, 
		'highPrice' => null, 
		'modificationDate'=>null,
		'onlyMine'=>null, 
		'whereClause'=>'', 
		'orderByClause'=>'' 
		);
		$events = getAllEventDetailsBasicFormating($paramGetEvents);
	}
	//displayGetEventsDetailsBasicFormating();
	function displayGetEventsDetailsComma() {
		global $events;
		$paramGetEvents = array(
		'websiteConfigID' => WEB_CONF_ID,
		'numberOfEvents'=>null, 
		'eventID' => null, 
		'eventName' => 'wicked', 
		'eventDate' => null, 
		'beginDate'=>null, 
		'endDate' => null, 
		'venueID'=>null, 
		'venueName' => '', 
		'stateProvDesc' => '', 
		'stateID'=>null, 'cityZip' => '', 
		'nearZip' => '', 
		'parentCategoryID' => null, 
		'childCategoryID' => null, 
		'grandchildCategoryID' => null, 
		'performerID' => null, 
		'performerName' => '', 
		'noPerformers' => null, 
		'lowPrice' => null, 
		'highPrice' => null, 
		'modificationDate'=>null,
		'onlyMine'=>null, 
		'whereClause'=>'', 
		'orderByClause'=>'' 
		);
		$events = getAllEventDetailsComma($paramGetEvents);
	}
	//displayGetEventsDetailsComma();
	function displayGetEventsDetailsArray() {
		global $events;
		$paramGetEvents = array(
		'websiteConfigID' => WEB_CONF_ID,
		'numberOfEvents'=>null, 
		'eventID' => null, 
		'eventName' => 'wicked', 
		'eventDate' => null, 
		'beginDate'=>null, 
		'endDate' => null, 
		'venueID'=>null, 
		'venueName' => '', 
		'stateProvDesc' => '', 
		'stateID'=>null, 'cityZip' => '', 
		'nearZip' => '', 
		'parentCategoryID' => null, 
		'childCategoryID' => null, 
		'grandchildCategoryID' => null, 
		'performerID' => null, 
		'performerName' => '', 
		'noPerformers' => null, 
		'lowPrice' => null, 
		'highPrice' => null, 
		'modificationDate'=>null,
		'onlyMine'=>null, 
		'whereClause'=>'', 
		'orderByClause'=>'' 
		);
		foreach (getAllEventDetailsArray($paramGetEvents) as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v;
			}
			$events .= "<br>";
		};
	}
	//displayGetEventsDetailsArray();
	
	function displayGetCategories(){
		global $events;
		foreach (getCategories() as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v;
			}
			$events .= "<br>";
		};
	}
	//displayGetCategories();
	function displayGetCategoriesMasterList(){
		global $events;
		foreach (getCategoriesMasterList() as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v;
			}
			$events .= "<br>";
		};
	}
	//displayGetCategories();
	function displayGetCountries(){
		global $events;
		foreach (getCountries() as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v . "<br>";
			}
			$events .= "<br>";
		};
	}
	//displayGetCountries();
	function displayGetCountryByID(){
		global $events;
		$paramCounteryID=array('websiteConfigID' => WEB_CONF_ID, 'countryID' => 217);
		foreach (getCountryByID($paramCounteryID) as $key => $value) {
			$events .= $key . ": " . $value . "<br>";
		};
	}
	//displayGetCountryByID();
	
	/*THIS RETURNS NOTHING IN TEST MODE (ALWAYS NO RESULTS) *
	 *        |                                             *
	 *       \|/                                            */
	function displayGetEventPerformers(){
		global $events;
		foreach (getEventPerformers() as $key => $value) {
			foreach ($value as $k => $v) {
				$events .= $k . ": " . $v . "<br>";
			}
			$events .= "<br>";
		};
	}
	//displayGetEventPerformers();
	function displayGetEventTickets() {
		global $events;
		$paramGetEventTickets = array('websiteConfigID' => WEB_CONF_ID, 'numberOfRecords' => TICKET_PAGINATION, 'eventID' => 203518, 'lowPrice' => null, 'highPrice' => null, 'ticketGroupID' => null, 'mandatoryCreditCard' => null, 'requestedSplit' => null, 'sortColumn' => null, 'sortDescending' => null);
		foreach (getEventTickets($paramGetEventTickets) as $key => $obj) {
			foreach ($obj as $ke => $val) {
				for ($q = 0; $q < count($val); $q++) {
					$events .= $ke . ": ";
					if ($ke == 'ValidSplits') {
						foreach ($val as $k => $v) {
							if(is_array($v)){
								foreach($v as $spltN => $spltV){
									$events .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#" . $spltN . ": " . $spltV;
								}
							}else{
								$events .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#" . $k . ": " . $v;
							}
						}
					} else {
						$events .= $val;
					}
				}
				//}
			}
			$events .= "<br>";
		}
	}
	//displayGetEventTickets();
	
	function displayGetEventsCompressed() {
		$paramGetEvents = array(
		'websiteConfigID' => WEB_CONF_ID,
		'numberOfEvents'=>null, 
		'eventID' => null, 
		'eventName' => 'wicked', 
		'eventDate' => null, 
		'beginDate'=>null, 
		'endDate' => null, 
		'venueID'=>null, 
		'venueName' => '', 
		'stateProvDesc' => '', 
		'stateID'=>null, 
		'cityZip' => '', 
		'nearZip' => '', 
		'parentCategoryID' => null, 
		'childCategoryID' => null, 
		'grandchildCategoryID' => null, 
		'performerID' => null, 
		'performerName' => '', 
		'noPerformers' => null, 
		'lowPrice' => null, 
		'highPrice' => null, 
		'modificationDate'=>null,
		'onlyMine'=>null, 
		'whereClause'=>'', 
		'orderByClause'=>'' 
		);
		print_r(getEventsCompressed($paramGetEvents));
		return getEventsCompressed($paramGetEvents);
	}
	//displayGetEventsCompressed();
	function displayGetHighInventoryPerformers() {
		global $events;
		$paramGetHighInventoryPerformers = array(
			'WebsiteConfigID' => WEB_CONF_ID, 
			'numReturned' => HIGH_INVENTORY_PERFORMERS_LENGTH, 
			'parentCategoryID' => null, 
			'childCategoryID' => null, 
			'grandchildCategoryID' => null
		);
		foreach (getHighInventoryPerformers($paramGetHighInventoryPerformers) as $key => $obj) {
			foreach ($obj as $ke => $val) {
				for ($q = 0; $q < count($val); $q++) {
					$events .= $ke . ": ";
					if ($ke == 'Category') {
						foreach ($val as $k => $v) {
							$events .= $k . ": " . $v . "<br>";
						}
					} else {
						$events .= $val;
					}
				}
			}
			$events .= "<br>";
		}
	}
	//displayGetHighInventoryPerformers();
	function displayGetHighSalesPerformers() {
		global $events;
		$paramGetHighSalesPerformers = array(
			'WebsiteConfigID' => WEB_CONF_ID, 
			'numReturned' => HIGH_INVENTORY_PERFORMERS_LENGTH, 
			'parentCategoryID' => null, 
			'childCategoryID' => null, 
			'grandchildCategoryID' => null
		);
		foreach (getHighSalesPerformers($paramGetHighSalesPerformers) as $key => $obj) {
			foreach ($obj as $ke => $val) {
				for ($q = 0; $q < count($val); $q++) {
					$events .= $ke . ": ";
					if ($ke == 'Category') {
						foreach ($val as $k => $v) {
							$events .= $k . ": " . $v . "<br>";
						}
					} else {
						$events .= $val;
					}
				}
			}
			$events .= "<br>";
		}
	}
	//displayGetHighSalesPerformers();
	function displayGetPerformerByCategory() {
		global $events;
		$paramGetPerformerByCategory = array(
			'WebsiteConfigID' => WEB_CONF_ID, 
			'numReturned' => null, 
			'parentCategoryID' => null, 
			'childCategoryID' => null, 
			'grandchildCategoryID' => null, 
			'hasEvent' => null
		);
		foreach (getPerformerByCategory($paramGetPerformerByCategory) as $key => $obj) {
			foreach ($obj as $ke => $val) {
				for ($q = 0; $q < count($val); $q++) {
					$events .= $ke . ": ";
					if ($ke == 'Category') {
						foreach ($val as $k => $v) {
							$events .= $k . ": " . $v . "<br>";
						}
					} else {
						$events .= $val;
					}
				}
			}
			$events .= "<br>";
		}
	}
	//displayGetPerformerByCategory();
	function displayGetPerformerByCategoryCompressed() {
		global $events;
		$paramGetPerformerByCategoryCompressed = array(
			'WebsiteConfigID' => WEB_CONF_ID, 
			'numReturned' => null, 
			'parentCategoryID' => null, 
			'childCategoryID' => null, 
			'grandchildCategoryID' => null, 
			'hasEvent' => null
		);
		$events=getPerformerByCategoryCompressed($paramGetPerformerByCategoryCompressed);
	}
	//displayGetPerformerByCategoryCompressed();
	function displayGetPricingInfo(){
		global $events;
		$paramPricingInfo=array('websiteConfigID' => WEB_CONF_ID, 'eventID' => '1699888');
		foreach (getPricingInfo($paramPricingInfo) as $key => $value) {
			$events .= $key . ": " . $value . "<br>";
		};
	}
	//displayGetPricingInfo();
	function displayGetStates(){
		global $events;
		$paramGetStates=array('websiteConfigID' => WEB_CONF_ID, 'countryID' => 217);
		foreach (getStates($paramGetStates) as $key => $value) {
			foreach($value as $k => $v){
				$events .= $k . ": " . $v . "<br>";
			}
		};
	}
	//displayGetStates();
	function displayGetSublevelCategories(){
		global $events;
		$paramGetSublevelCategories=array('websiteConfigID' => WEB_CONF_ID, 'parentCategoryID' => 2, 'childCategoryID'=>null);
		foreach (getSublevelCategories($paramGetSublevelCategories) as $key => $value) {
			foreach($value as $k => $v){
				$events .= $k . ": " . $v . "<br>";
			}
		};
	}
	//displayGetSublevelCategories();
	function displayGetTickets() {
		global $events;
		$paramGetTickets = array('websiteConfigID' => WEB_CONF_ID, 'numberOfRecords' => TICKET_PAGINATION, 'eventID' => 1714400, 'lowPrice' => null, 'highPrice' => null, 'ticketGroupID' => null, 'mandatoryCreditCard' => null, 'requestedSplit' => null, 'sortColumn' => null, 'sortDescending' => null);
		foreach (getTickets($paramGetTickets) as $key => $obj) {
			foreach ($obj as $ke => $val) {
				for ($q = 0; $q < count($val); $q++) {
					$events .= $ke . ": ";
					if ($ke == 'ValidSplits') {
						foreach ($val as $k => $v) {
							if(is_array($v)){
								foreach($v as $spltN => $spltV){
									$events .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#" . $spltN . ": " . $spltV;
								}
							}else{
								$events .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#" . $k . ": " . $v;
							}
						}
					} else {
						$events .= $val;
					}
				}
				//}
			}
			$events .= "<br>";
		}
	}
	//displayGetTickets();
	function displayVenueData() {
		global $events;
		$paramVenueData = array('websiteConfigID' => WEB_CONF_ID, 'venueID' => 541);
		//$paramVenueData = array('websiteConfigID' => WEB_CONF_ID);
		foreach (getVenueData($paramVenueData) as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $k => $v) {
					$events .= $k . ": " . $v . "<br>";
				}
			} else {
				$events .= $key . ": " . $value . "<br>";
			}
			
		};
	}
	//displayVenueData();
	
	function displayGetVenueConfigurations() {
		global $events;
		$paramVenueConfigurations = array('websiteConfigID' => WEB_CONF_ID, 'venueID' => 541);
		foreach (getVenueConfigurations($paramVenueConfigurations) as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $k => $v) {
					$events .= $k . ": " . $v;
				}
			} else {
				$events .= $key . ": " . $value;
			}$events .= "<br>";

		};
	}
	//displayGetVenueConfigurations();
	echo $events;
?>