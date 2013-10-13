<?php 

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

class TNEvent extends TicketNetworkBase{
	
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	
	/**
	 * Values that can be set as params via send or get to TicketNetwork
	 * 
	 * 	'websiteConfigID' => WEB_CONF_ID, - Already set in base class
		'numberOfEvents'=>null, - pagination
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
		'orderByClause'=>'' - defaults to Date
		
	 * @param string $params
	 * @return TNEvent
	 */
	public function get($params=false){
	
		$this->_request['method'] = 'GetEvents';
	
		if($params){
			$this->set($params);
			if(array_key_exists('eventID', $params)){
				$this->_request['method'] = 'GetEvents';
			}
		}
	
		return $this;
	}
	
	/**
	 * 
	 * @param string $params
	 * @return TNEvent
	 */
	public function search($params=null){
		$this->_request['method'] = 'SearchEvents';
	
		if($params){
			$this->set($params);
		}
	
		return $this;
	}
	
	
	/**
	 * Parse the results from TicketNetwork
	 * @return string|unknown
	 */
	public function parse(){
		$this->_data = array();
	
		try{
			parent::parse();
			
			if(!empty($this->_response)){
				if($this->_request['method'] == 'GetEvents'){
					if(is_array($this->_response->GetEventsResult->Event)){
						foreach($this->_response->GetEventsResult->Event as $event){
							$this->_data[] = $event;
						}
					}else if(is_object($this->_response->GetEventsResult->Event)){
						$this->_data = $this->_response->GetEventsResult->Event;
					}else{
						$this->_data = null;
					}
				}else if($this->_request['method'] == 'SearchEvents'){
					if(is_array($this->_response->SearchEventsResult->Event)){
						foreach($this->_response->SearchEventsResult->Event as $event){
							$this->_data[] = $event;
						}
					}else if(is_object($this->_response->SearchEventsResult->Event)){
						$this->_data = $this->_response->SearchEventsResult->Event;
					}else{
						$this->_data = null;
					}
				}else{
					if(!empty($this->_response->GetCountryByIDResult)){
						$this->_data = $this->_response->GetCountryByIDResult;
					}else{
						$this->_data = null;
					}
				}
			}
	
		}catch(TNException $e){
		}
	
		return $this;
	}
	
	protected function _defaults(){
		parent::_defaults();
	
		$this->_request = array(
				'method' => 'GetEvents',
				'parameters' => array('numberOfEvents'=>25, 'orderByClause'=>'Date ASC')
		);
	}
}
