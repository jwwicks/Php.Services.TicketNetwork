<?php
require_once ('tnwsConstants.php');
/*
 Web Service Calls
 SearchEvents uses a cached version of the entire Events table in the Exchange database,
 returning a faster result. The cache is refreshed every 10 minutes, and Events are not Tickets
 Event objects contain tickets, do not cache tickets, but events are ok to cache
 */function searchEventsDetailsBasicFormating($keyWordParams) {	$resultString = '';	$keyWordParams['websiteConfigID'] = WEB_CONF_ID;	if($keyWordParams['searchTerms']) {		$client = new SoapClient(WSDL);		$result = $client -> __soapCall('SearchEvents', array('parameters' => $keyWordParams));		if(is_soap_fault($result)) {			echo '<h2>Fault</h2><pre>';			print_r($result);			echo '</pre>';		}
		$eventDetails="";		if(empty($result)){			return "No results match the specified terms";		}else {
			for($q=0;$q<count($result->SearchEventsResult->Event);$q++){
				$resultsObj=$result->SearchEventsResult->Event[$q];
				$eventDetails.="<b>ID: </b>".$resultsObj->ID."<br>";
				$eventDetails.="<b>Name: </b>".$resultsObj->Name."<br>";
				$eventDetails.="<b>Date: </b>".$resultsObj->Date."<br>";
				$eventDetails.="<b>DisplayDate: </b>".$resultsObj->DisplayDate."<br>";
				$eventDetails.="<b>Venue: </b>".$resultsObj->Venue."<br>";
				$eventDetails.="<b>City: </b>".$resultsObj->City."<br>";
				$eventDetails.="<b>StateProvince: </b>".$resultsObj->StateProvince."<br>";
				$eventDetails.="<b>ParentCategoryID: </b>".$resultsObj->ParentCategoryID."<br>";
				$eventDetails.="<b>ChildCategoryID: </b>".$resultsObj->ChildCategoryID."<br>";
				$eventDetails.="<b>GrandchildCategoryID: </b>".$resultsObj->GrandchildCategoryID."<br>";
				$eventDetails.="<b>MapURL: </b>".$resultsObj->MapURL."<br>";
				$eventDetails.="<b>VenueID: </b>".$resultsObj->VenueID."<br>";
				$eventDetails.="<b>StateProvinceID: </b>".$resultsObj->StateProvinceID."<br>";
				$eventDetails.="<b>VenueConfigurationID: </b>".$resultsObj->VenueConfigurationID."<br>";
				$eventDetails.="<b>Clicks: </b>".$resultsObj->Clicks."<br>";
				$eventDetails.="<b>IsWomensEvent: </b>".$resultsObj->IsWomensEvent."<br><br>";
			}
			unset($client);
			return $eventDetails;		}	}}function searchEventsDetailsComma($keyWordParams) {
	$resultString = '';
	$keyWordParams['websiteConfigID'] = WEB_CONF_ID;
	if($keyWordParams['searchTerms']) {
		$client = new SoapClient(WSDL);
		$result = $client -> __soapCall('SearchEvents', array('parameters' => $keyWordParams));
		if(is_soap_fault($result)) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		$eventDetails="";
		if(empty($result)){
			return "No results match the specified terms";
		}else {
			for($q=0;$q<count($result->SearchEventsResult->Event);$q++){
				$resultsObj=$result->SearchEventsResult->Event[$q];
				$eventDetails.=$resultsObj->ID.",";
				$eventDetails.=$resultsObj->Name.",";
				$eventDetails.=$resultsObj->Date.",";
				$eventDetails.=$resultsObj->DisplayDate.",";
				$eventDetails.=$resultsObj->Venue;
				$eventDetails.=$resultsObj->City.",";
				$eventDetails.=$resultsObj->StateProvince.",";
				$eventDetails.=$resultsObj->ParentCategoryID.",";
				$eventDetails.=$resultsObj->ChildCategoryID.",";
				$eventDetails.=$resultsObj->GrandchildCategoryID.",";
				$eventDetails.=$resultsObj->MapURL.",";
				$eventDetails.=$resultsObj->VenueID.",";
				$eventDetails.=$resultsObj->StateProvinceID.",";
				$eventDetails.=$resultsObj->VenueConfigurationID."";
				$eventDetails.=$resultsObj->Clicks.",";
				$eventDetails.=$resultsObj->IsWomensEvent."|";
			}
			unset($client);
			return $eventDetails;
			
		}
	}
}
function searchEventsDetailsArray($keyWordParams) {
	$resultString = '';
	$keyWordParams['websiteConfigID'] = WEB_CONF_ID;
	
	if($keyWordParams['searchTerms']) {
		$client = new SoapClient(WSDL);
		$result = $client->__soapCall('SearchEvents', array('parameters' => $keyWordParams));
		if(is_soap_fault($result)){
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		
		$eventDetails="";
		if(empty($result)){
			echo "No results match the specified terms";
		}else {
			for($q=0;$q<count($result->SearchEventsResult->Event);$q++){
				$resultsObj=$result->SearchEventsResult->Event[$q];
				$eTickCount;
				foreach ($resultsObj as $k => $v) {
					global $eTickCount;
					$eventDetails[$eTickCount]=array($k=>$v);
					$eTickCount++;
				}
			}
			unset($client);
			return $eventDetails;
			
		}
	}
}
function getAllEventDetailsBasicFormating($param) {	$arrayString = "!";	$param['websiteConfigID'] = WEB_CONF_ID;	$parametersExist = false;	$paramkeys = array_keys($param);	$paramvalues = array_values($param);	for($a = 1; $a < count($param); $a++) {		if($param[$paramkeys[$a]]) {			$parametersExist = true;			$arrayString=$arrayString.$paramvalues[$a]."?";			break;		}	}	$eventDetails="";	if($parametersExist) {		$client = new SoapClient(WSDL);		$result = $client -> __soapCall('GetEvents', array('parameters' => $param));		if(is_soap_fault($result)) {			echo '<h2>Fault</h2><pre>';			print_r($result);			echo '</pre>';		}		if(empty($result))			return "empty result";		else {			for($q=0;$q<count($result->GetEventsResult->Event);$q++){				$resultsObj=$result->GetEventsResult->Event[$q];				$eventDetails.="<b>ID: </b>".$resultsObj->ID."<br>";				$eventDetails.="<b>Name: </b>".$resultsObj->Name."<br>";				$eventDetails.="<b>Date: </b>".$resultsObj->Date."<br>";				$eventDetails.="<b>DisplayDate: </b>".$resultsObj->DisplayDate."<br>";				$eventDetails.="<b>Venue: </b>".$resultsObj->Venue."<br>";				$eventDetails.="<b>City: </b>".$resultsObj->City."<br>";				$eventDetails.="<b>StateProvince: </b>".$resultsObj->StateProvince."<br>";				$eventDetails.="<b>ParentCategoryID: </b>".$resultsObj->ParentCategoryID."<br>";				$eventDetails.="<b>ChildCategoryID: </b>".$resultsObj->ChildCategoryID."<br>";				$eventDetails.="<b>GrandchildCategoryID: </b>".$resultsObj->GrandchildCategoryID."<br>";				$eventDetails.="<b>MapURL: </b>".$resultsObj->MapURL."<br>";				$eventDetails.="<b>VenueID: </b>".$resultsObj->VenueID."<br>";				$eventDetails.="<b>StateProvinceID: </b>".$resultsObj->StateProvinceID."<br>";				$eventDetails.="<b>VenueConfigurationID: </b>".$resultsObj->VenueConfigurationID."<br>";				$eventDetails.="<b>Clicks: </b>".$resultsObj->Clicks."<br>";				$eventDetails.="<b>IsWomensEvent: </b>".$resultsObj->IsWomensEvent."<br><br>";			}
			unset($client);			return $eventDetails;
		}
	} else { // no parameters
		return 'Please specify some search terms.';
	}
}
function getAllEventDetailsComma($param) {	$arrayString = "!";	$param['websiteConfigID'] = WEB_CONF_ID;	$parametersExist = false;	$paramkeys = array_keys($param);	$paramvalues = array_values($param);	for($a = 1; $a < count($param); $a++) {		if($param[$paramkeys[$a]]) {			$parametersExist = true;			$arrayString=$arrayString.$paramvalues[$a]."?";			break;		}	}	$eventDetails="";	if($parametersExist) {		$client = new SoapClient(WSDL);		$result = $client -> __soapCall('GetEvents', array('parameters' => $param));		if(is_soap_fault($result)) {			echo '<h2>Fault</h2><pre>';			print_r($result);			echo '</pre>';		}		if(empty($result))			return "empty result";		else {			for($q=0;$q<count($result->GetEventsResult->Event);$q++){				$resultsObj=$result->GetEventsResult->Event[$q];				$eventDetails.=$resultsObj->ID.",";				$eventDetails.=$resultsObj->Name.",";				$eventDetails.=$resultsObj->Date.",";				$eventDetails.=$resultsObj->DisplayDate.",";				$eventDetails.=$resultsObj->Venue;				$eventDetails.=$resultsObj->City.",";				$eventDetails.=$resultsObj->StateProvince.",";				$eventDetails.=$resultsObj->ParentCategoryID.",";				$eventDetails.=$resultsObj->ChildCategoryID.",";				$eventDetails.=$resultsObj->GrandchildCategoryID.",";				$eventDetails.=$resultsObj->MapURL.",";				$eventDetails.=$resultsObj->VenueID.",";				$eventDetails.=$resultsObj->StateProvinceID.",";				$eventDetails.=$resultsObj->VenueConfigurationID."";				$eventDetails.=$resultsObj->Clicks.",";				$eventDetails.=$resultsObj->IsWomensEvent."|";			}			unset($client);			return $eventDetails;		}	} else { // no parameters		return 'Please specify some search terms.';	}}
function getAllEventDetailsArray($param) {
	$arrayString = "!";
	$param['websiteConfigID'] = WEB_CONF_ID;
	$parametersExist = false;
	$paramkeys = array_keys($param);
	$paramvalues = array_values($param);
	for($a = 1; $a < count($param); $a++) {
		if($param[$paramkeys[$a]]) {
			$parametersExist = true;
			$arrayString=$arrayString.$paramvalues[$a]."?";
			break;
		}
	}
	if($parametersExist) {
		$client = new SoapClient(WSDL);
		$result = $client -> __soapCall('GetEvents', array('parameters' => $param));
		if(is_soap_fault($result)) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		if(empty($result))
			return "empty result";
		else {
			$eventDetails;
			//var_dump(count($result->GetEventsResult->Event));
			$numEvents = count($result->GetEventsResult->Event);
			for($q=0;$q<$numEvents;$q++){
				if($numEvents > 1){
					$resultsObj=$result->GetEventsResult->Event[$q];
				}else{
					$resultsObj=$result->GetEventsResult->Event;
				}
				
				$eTickCount;
				if(is_array($resultObj)){
					foreach($resultsObj as $k => $v){
						global $eTickCount;
						$eventDetails[$eTickCount]=array($k=>$v);
						$eTickCount++;
					}
				}else if(is_object($resultsObj)){
					return $resultsObj;
				}
			}
			unset($client);
			return $eventDetails;
		}
	} else { // no parameters
		return 'Please specify some search terms.';
	}
}

function getCategories(){
	$websiteConfigID = WEB_CONF_ID;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetCategories', array('parameters' => $websiteConfigID));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$categoryDetails="";
	unset($client);
	if(empty($result -> GetCategoriesResult))
		return "empty result";
	else {
		for($q=0;$q<count($result->GetCategoriesResult->Category);$q++){
			$resultsObj=$result->GetCategoriesResult->Category[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$categoryDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}
		return $categoryDetails;
	}
}

function getCategoriesMasterList(){
	$websiteConfigID = WEB_CONF_ID;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetCategoriesMasterList', array('parameters' => $websiteConfigID));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$categoryDetails="";
	unset($client);
	if(empty($result -> GetCategoriesMasterListResult))
		return "empty result";
	else {
		for($q=0;$q<count($result->GetCategoriesMasterListResult->Category);$q++){
			$resultsObj=$result->GetCategoriesMasterListResult->Category[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$categoryDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}
		return $categoryDetails;
	}
}

function getCountries(){
	$websiteConfigID = WEB_CONF_ID;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetCountries', array('parameters' => $websiteConfigID));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$countryDetails="";
	unset($client);
	if(empty($result -> GetCountriesResult))
		return "empty result";
	else {
		for($q=0;$q<count($result->GetCountriesResult->Country);$q++){
			$resultsObj=$result->GetCountriesResult->Country[$q];
			$countryDetails[$q]=array(
				'ID'=>$resultsObj->ID,
				'Name'=>$resultsObj->Name,
				'CurrencyTypeDesc'=>$resultsObj->CurrencyTypeDesc,
				'CurrencyTypeAbbr'=>$resultsObj->CurrencyTypeAbbr,
				'ConversionToUSD'=>$resultsObj->ConversionToUSD,
				'ConversionFromUSD'=>$resultsObj->ConversionFromUSD
			);
			if(!empty($resultsObj->Abbreviation)){
				$countryDetails[$q]['Abbreviation']=$resultsObj->Abbreviation;
			}
			if(!empty($resultsObj->InternationalPhoneCode)){
				$countryDetails[$q]['InternationalPhoneCode']=$resultsObj->InternationalPhoneCode;
			}
		}
		return $countryDetails;
	}
}

function getCountryByID($param){
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetCountryByID', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$countryDetails="";
	unset($client);
	if(empty($result->GetCountryByIDResult))
		return "empty result";
	else {
			$countryDetails=array(
				'ID'=>$result->GetCountryByIDResult->ID,
				'Name'=>$result->GetCountryByIDResult->Name,
				'CurrencyTypeDesc'=>$result->GetCountryByIDResult->CurrencyTypeDesc,
				'CurrencyTypeAbbr'=>$result->GetCountryByIDResult->CurrencyTypeAbbr,
				'ConversionToUSD'=>$result->GetCountryByIDResult->ConversionToUSD,
				'ConversionFromUSD'=>$result->GetCountryByIDResult->ConversionFromUSD
			);
			if(!empty($resultsObj->Abbreviation)){
				$countryDetails[$q]['Abbreviation']=$resultsObj->Abbreviation;
			}
			if(!empty($resultsObj->InternationalPhoneCode)){
				$countryDetails[$q]['InternationalPhoneCode']=$resultsObj->InternationalPhoneCode;
			}
		return $countryDetails;
	}
}

function getEventPerformers(){
	$websiteConfigID = WEB_CONF_ID;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetEventPerformers', array('parameters' => $websiteConfigID));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$eventPerformerDetails="";
	unset($client);
	if(empty($result))
		return "empty result";
	else {
		if(is_array($result)){
		for($q=0;$q<count($result->GetEventPerformersResult->EventPerformer);$q++){
			$resultsObj=$result->GetEventPerformersResult->EventPerformer[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$eventPerformerDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}
		return $eventPerformerDetails;
		}else{
			return $result;
		}
	}
}

function getEventTickets($param) {
	/*  param list
	 websiteConfigID:
	 numberOfRecords:
	 eventID:
	 lowPrice:
	 highPrice:
	 ticketGroupID:
	 mandatoryCreditCard:
	 requestedSplit:
	 sortColumn:
	 sortDescending:
	 */
	$resultString = '';
	$param['websiteConfigID'] = WEB_CONF_ID;
	$param['numberOfRecords'] = TICKET_PAGINATION;
	$parametersExist = false;
	$paramkeys = array_keys($param);
	for($a = 2; $a < count($param); $a++) {
		if($param[$paramkeys[$a]]) {
			$parametersExist = true;
			break;
		}
	}
	if($parametersExist) {
		$client = new SoapClient(WSDL);
		$result = $client -> __soapCall('GetEventTickets', array('parameters' => $param));
		if(is_soap_fault($result)) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		$paramTickets;
		unset($client);
		if(empty($result)){
			return "No tickets exist for that event";
		}else {
			for($q=0;$q<count($result->GetEventTicketsResult->Tickets->TicketGroup);$q++){//
				$resultsObj=$result->GetEventTicketsResult->Tickets->TicketGroup[$q];
				$eTickCount;
				foreach ($resultsObj as $k => $v) {
					global $eTickCount;
					$paramTickets[$eTickCount]=array($k=>$v);
					$eTickCount++;
				}
			}
			return $paramTickets;
		}
	}
}

function getEventsCompressed($param) {
	$arrayString = "!";
	$param['websiteConfigID'] = WEB_CONF_ID;
	$parametersExist = false;
	$paramkeys = array_keys($param);
	$paramvalues = array_values($param);
	for($a = 1; $a < count($param); $a++) {
		if($param[$paramkeys[$a]]) {
			$parametersExist = true;
			$arrayString=$arrayString.$paramvalues[$a]."?";
			break;
		}
	}
	if($parametersExist) {
		$client = new SoapClient(WSDL);
		$result = $client -> __soapCall('GetEventsCompressed', array('parameters' => $param));
		if(is_soap_fault($result)) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		if(empty($result))
			return "empty result";
		else {
			return $eventDetails=$result->GetEventsCompressedResult;
		}
	} else { // no parameters
		return 'Please specify some search terms.';
	}
}function getHighInventoryPerformers($param) {
	$resultString = '';
	/* params=
		websiteConfigID: 
		numReturned: 
		parentCategoryID: 
		childCategoryID: 
		grandchildCategoryID: 
	*/
	$param['websiteConfigID'] = WEB_CONF_ID;
	$param['numReturned'] = HIGH_INVENTORY_PERFORMERS_LENGTH;
	$client = new SoapClient(WSDL);	$result = $client -> __soapCall('GetHighInventoryPerformers', array('parameters' => $param));	if(is_soap_fault($result)) {		echo '<h2>Fault</h2><pre>';		print_r($result);		echo '</pre>';	}
	$performerDetails="";
	unset($client);	if(empty($result -> GetHighInventoryPerformersResult))		return "empty result";	else {		for($q=0;$q<count($result->GetHighInventoryPerformersResult->PerformerPercent);$q++){
			$resultsObj=$result->GetHighInventoryPerformersResult->PerformerPercent[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$performerDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}		return $performerDetails;	}}function getHighSalesPerformers($param) {
	$resultString = '';
	/* params=		websiteConfigID:		numReturned:		parentCategoryID:		childCategoryID:		grandchildCategoryID:	*/	$param['websiteConfigID'] = WEB_CONF_ID;	$param['numReturned'] = HIGH_SALES_PERFORMERS_LENGTH;	$client = new SoapClient(WSDL);	$result = $client -> __soapCall('GetHighSalesPerformers', array('parameters' => $param));	if(is_soap_fault($result)) {		echo '<h2>Fault</h2><pre>';		print_r($result);		echo '</pre>';	}
	$performerDetails="";	unset($client);	if(empty($result)){		return "empty result";	}else {
		for($q=0;$q<count($result->GetHighSalesPerformersResult->PerformerPercent);$q++){
			$resultsObj=$result->GetHighSalesPerformersResult->PerformerPercent[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$performerDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}		return $performerDetails;	}}
function getPerformerByCategory($param) {
	$resultString = '';
	$param['websiteConfigID'] = WEB_CONF_ID;
	$param['numReturned'] = HIGH_SALES_PERFORMERS_LENGTH;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetPerformerByCategory', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$performerDetails="";
	unset($client);
	if(empty($result)){
		return "empty result";
	}else {
		for($q=0;$q<count($result->GetPerformerByCategoryResult->Performer);$q++){
			$resultsObj=$result->GetPerformerByCategoryResult->Performer[$q];
			$eTickCount;
			foreach ($resultsObj as $k => $v) {
				global $eTickCount;
				$performerDetails[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}
		return $performerDetails;
	}
}
function getPerformerByCategoryCompressed($param) {
	$resultString = '';
	$param['websiteConfigID'] = WEB_CONF_ID;
	$param['numReturned'] = HIGH_SALES_PERFORMERS_LENGTH;
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetPerformerByCategoryCompressed', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$performerDetails="";
	unset($client);
	if(empty($result)){
		return "empty result";
	}else {
		return $result->GetPerformerByCategoryCompressedResult;
	}
}

function getPricingInfo($param){
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetPricingInfo', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$pricingInfo="";
	unset($client);
	if(empty($result->GetPricingInfoResult))
		return "empty result";
	else {
		if(is_array($result->GetPricingInfoResult)){
			$eTickCount;
			foreach ($result->GetPricingInfoResult as $k => $v) {
				global $eTickCount;
				$pricingInfo[$eTickCount]=array($k=>$v);
				$eTickCount++;
			}
		}else{
			$pricingInfo=$result->GetPricingInfoResult;
		}
		return $pricingInfo;
	}
}

function getStates($param){
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetStates', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$states="";
	unset($client);
	if(empty($result->GetStatesResult))
		return "empty result";
	else {
		if(is_array($result->GetStatesResult->States)){
			$eTickCount;
			foreach ($result->GetStatesResult->States as $key => $value) {
				foreach($value as $k => $v){
					global $eTickCount;
					$states[$eTickCount]=array($k=>$v);
					$eTickCount++;
				}
			}
		}else{
			$states=$result->GetPricingInfoResult;
		}
		return $states;
	}
}

function getSublevelCategories($param){
	$client = new SoapClient(WSDL);
	$result = $client -> __soapCall('GetSublevelCategories', array('parameters' => $param));
	if(is_soap_fault($result)) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
	$sublevelCategories="";
	unset($client);
	if(empty($result->GetSublevelCategoriesResult))
		return "empty result";
	else {
		if(is_array($result->GetSublevelCategoriesResult->Category)){
			$eTickCount;
			foreach ($result->GetSublevelCategoriesResult->Category as $key => $value) {
				foreach($value as $k => $v){
					global $eTickCount;
					$sublevelCategories[$eTickCount]=array($k=>$v);
					$eTickCount++;
				}
			}
		}else{
			$sublevelCategories=$result->GetPricingInfoResult;
		}
		return $sublevelCategories;
	}
}
function getTickets($param) {
	/*  param list	 websiteConfigID:	 numberOfRecords:	 eventID:	 lowPrice:	 highPrice:	 ticketGroupID:	 mandatoryCreditCard:	 requestedSplit:	 sortColumn:	 sortDescending:	 */	$resultString = '';	$param['websiteConfigID'] = WEB_CONF_ID;	$param['numberOfRecords'] = TICKET_PAGINATION;	$parametersExist = false;	$paramkeys = array_keys($param);	for($a = 2; $a < count($param); $a++) {		if($param[$paramkeys[$a]]) {			$parametersExist = true;			break;		}	}
	
	//die(var_dump($param));
		if($parametersExist) {		$client = new SoapClient(WSDL);		$result = $client -> __soapCall('GetTickets', array('parameters' => $param));
		//var_dump($result);
				if(is_soap_fault($result)) {			echo '<h2>Fault</h2><pre>';			print_r($result);			echo '</pre>';		}
		$paramTickets="";		unset($client);		if(empty($result->GetTicketsResult->TicketGroup)){			return "No tickets exist for that event";		}else {
			for($q=0;$q<count($result->GetTicketsResult->TicketGroup);$q++){//
				$resultsObj=$result->GetTicketsResult->TicketGroup[$q];
				$eTickCount;
				foreach ($resultsObj as $k => $v) {
					global $eTickCount;
					$paramTickets[$eTickCount]=array($k=>$v);
					$eTickCount++;
				}
			}		}return $paramTickets;	}}
function getVenueData($param) {	$resultString = '';	$param['websiteConfigID'] = WEB_CONF_ID;	if($param['venueID']) {		$client = new SoapClient(WSDL);		$result = $client -> __soapCall('GetVenue', array('parameters' => $param));		if(is_soap_fault($result)) {			echo '<h2>Fault</h2><pre>';			print_r($result);			echo '</pre>';		}
		$paramVenueData="";		unset($client);		if(empty($result)){			return "No Venue Data Exists";		}else {			if(isset($result->GetVenueResult->Venue)) {				if(is_array($result -> GetVenueResult -> Venue)) {
					for($q=0;$q<count($result->GetVenueResult->Venue);$q++){//
						$resultsObj=$result->GetVenueResult->Venue[$q];
						$eTickCount;
						foreach ($resultsObj as $k => $v) {
							global $eTickCount;
							$paramVenueData[$eTickCount]=array($k=>$v);
							$eTickCount++;
						}
					}
				}else{
					$resultsObj=$result->GetVenueResult->Venue;
					$eTickCount;
					foreach ($resultsObj as $k => $v) {
						global $eTickCount;
						$paramVenueData[$eTickCount]=array($k=>$v);
						$eTickCount++;
					}
				}
				return $paramVenueData;			} else {				return '<div class="venueInfo">No Venues Exist For This Event</div>';			}		}	} else {		return '<div class="venueInfo">There is no venue information available for this event</div>';	}}

function getVenueConfigurations($param) {
	$resultString = '';
	$param['websiteConfigID'] = WEB_CONF_ID;
	if($param['venueID']) {
		$client = new SoapClient(WSDL);
		$result = $client -> __soapCall('GetVenueConfigurations', array('parameters' => $param));
		if(is_soap_fault($result)) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		$paramVenueData="";
		unset($client);
		if(empty($result)){
			return "No Venue Data Exists";
		}else {
			if(isset($result->GetVenueConfigurationsResult->VenueConfiguration)) {
				if(is_array($result->GetVenueConfigurationsResult->VenueConfiguration)) {
					for($q=0;$q<count($result->GetVenueConfigurationsResult->VenueConfiguration);$q++){//
						$resultsObj=$result->GetVenueConfigurationsResult->VenueConfiguration[$q];
						$eTickCount;
						foreach ($resultsObj as $k => $v) {
							global $eTickCount;
							$paramVenueData[$eTickCount]=array($k=>$v);
							$eTickCount++;
						}
					}
				}else{
					$resultsObj=$result->GetVenueConfigurationsResult->VenueConfiguration;
					$eTickCount;
					foreach ($resultsObj as $k => $v) {
						global $eTickCount;
						$paramVenueData[$eTickCount]=array($k=>$v);
						$eTickCount++;
					}
				}
				return $paramVenueData;
			} else {
				return '<div class="venueInfo">No Venues Exist For This Event</div>';
			}
		}
	} else {
		return '<div class="venueInfo">There is no venue information available for this event</div>';
	}
}
/*OBSOLETE FUNCTIONS*/function getVenueMap($venueID) {	$param = array('websiteConfigID' => WEB_CONF_ID, 'venueID' => $venueID);	$client = new SoapClient(WSDL);	$result = $client -> __soapCall('GetVenueConfigurations', array('parameters' => $param));	if(is_soap_fault($result)) {		echo '<h2>Fault</h2><pre>';		print_r($result);		echo '</pre>';	}	unset($client);	if(empty($result)){		return '<div class="venueInfo">No maps exist for that venue</div>';	}else {		if(isset($result -> GetVenueConfigurationsResult -> VenueConfiguration)) {			if(is_array($result -> GetVenueConfigurationsResult -> VenueConfiguration)) {				//return $result -> GetVenueConfigurations -> VenueConfiguration[(($vConfID == '') || ($vConfID > count($result -> GetVenueConfigurationsStringInputsResult -> VenueConfiguration))) ? 0 : $vConfID] -> MapURL;				//return $result -> GetVenueConfigurations -> VenueConfiguration[(($vConfID == '') || ($vConfID > count($result -> GetVenueConfigurationsStringInputsResult -> VenueConfiguration))) ? 0 : $vConfID] -> MapURL;
				return $result -> GetVenueConfigurationsResult -> VenueConfiguration;
			} else {				return $result -> GetVenueConfigurationsResult -> VenueConfiguration -> MapURL;			}		} else {			return '<div class="venueInfo">No maps exist for that venue</div>';		}	}
	/*
	 */}/* These functions parse the returned arrays into results tables, also OBSOLETE */function resultsTable($resultsObj) {
	$resultString = '<table cellpadding="0" cellspacing="0" border="0">';	$resultString .= '<tr valign="top"><td class="resultsCol1">Event ID: ' . $resultsObj -> ID . '</td><td class="resultsCol2">Event Name: <span class="spn_underline">' . $resultsObj -> Name . '</span></td><td class="resultsCol3">Date: ' . $resultsObj -> DisplayDate . '</td></tr>';	$resultString .= '<tr><td>Venue: ' . $resultsObj -> Venue . '</td><td class="resultsCol2">City: ' . $resultsObj -> City . '</td><td>State: ' . $resultsObj -> StateProvince . '</td></tr>';	$resultString .= '</table>';	$vConfID = '';	if($resultsObj -> MapURL) {		$vConfID = $resultsObj -> VenueConfigurationID;	}	$resultString .= '<a href="/resultsTicket.php?eventID=' . $resultsObj -> ID . '&venueID=' . $resultsObj -> VenueID . '&venueConfID=' . $vConfID . '">View Tickets</a>';	return $resultString;}function highPerformersTable($resultsObj) {
	$resultString = '<a href="/resultsGeneral.php?performerID=' . $resultsObj -> Performer -> ID . '" alt="' . $resultsObj -> Performer -> Description . '">';
	$resultString .= $resultsObj -> Performer -> Description . '</a><br/>';	return $resultString;}function ticketsResultTable($ticketGroupObj) {	$returnString = '<div class="tg_container"><table cellspacing="0" cellpadding="0" border="0" class="ticket_group" width="100%"><tr><td class="tix_col1">';	$returnString .= 'Section: ' . $ticketGroupObj -> Section . '</td><td class="tix_col2">Row: ' . $ticketGroupObj -> Row . '</td></tr><tr><td>';	$returnString .= 'Price: $' . $ticketGroupObj -> ActualPrice . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Quantity: <select id="TGID_button_' . $ticketGroupObj -> ID . '_select">' . getSplits($ticketGroupObj -> ValidSplits -> int) . '</select></td>';	$returnString .= '<td class="tix_col2"><div id="TGID_button_' . $ticketGroupObj -> ID . '" class="buyTixButton" eventID="' . $ticketGroupObj -> EventID . '" TGID="' . $ticketGroupObj -> ID . '" prix="' . urlencode($ticketGroupObj -> ActualPrice) . '">Buy these tickets</div>';	$returnString .= '</tr></table>';	$returnString .= '<div class="tix_notes">Notes: ' . $ticketGroupObj -> Notes . '</div></div>';	return $returnString;}function getSplits($validSplitsArray) {	$returnString = '';	if(is_array($validSplitsArray)) {		for($z = 0; $z < count($validSplitsArray); $z++) {			$returnString .= '<option value="' . $validSplitsArray[$z] . '">' . $validSplitsArray[$z] . '</option>';		}	} else {		$returnString .= '<option value="' . $validSplitsArray . '">' . $validSplitsArray . '</option>';	}	return $returnString;}function venueResultTable($venueObj, $vConfID) {	$resultString = '<table cellspacing="0" cellpadding="0" border="0" class="venueInfoTable">';	$streetSection = $venueObj -> Street2 ? $venueObj -> Street1 . '<br/>' . $venueObj -> Street2 . '<br/>' : $venueObj -> Street1 . '<br/>';	$address = $streetSection . $venueObj -> City . ', ' . $venueObj -> StateProvince . ' ' . $venueObj -> ZipCode;	if($venueObj -> NumberOfConfigurations) { // get venue map according to the venue config id		$resultString .= '<tr><td><div>Name: ' . $venueObj -> Name . '<br/>Website: ' . $venueObj -> URL . '<br/>Address:  ' . $address . '</div></td></tr><tr>';		$resultString .= '<td><img src="http://www.indux.com/map/' . getVenueMap($venueObj -> ID, $vConfID) . '" /></td></tr>';	} else { // no vconf id means no venue map		$resultString .= '<tr><td><div>Name: ' . $venueObj -> Name . '<br/>Website: ' . $venueObj -> URL . '<br/>Address:  ' . $address . '</div></td></tr><tr>';		$resultString .= '<td>No map available for this venue</td></tr>';	}	return $resultString . '</table>';}
?>