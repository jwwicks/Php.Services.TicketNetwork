<?php 
/**
 * @file ticketnetwork_country.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

/**
 * @class TNCountry
 * @brief TicketNetwork Country
 *
 * @since    0.0.1
 */
class TNCountry extends TicketNetworkBase{
	
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	
	public function get($params=false){
	
		$this->_request['method'] = 'GetCountries';
		
		if($params){
			$this->set($params);
			if(array_key_exists('countryID', $params)){
				$this->_request['method'] = 'GetCountryByID';
			}
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
				if($this->_request['method'] == 'GetCountries'){
					if(is_array($this->_response->GetCountriesResult->Country)){
						foreach($this->_response->GetCountriesResult->Country as $country){
							$this->_data[] = $country;
						}
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
			'method' => '',
			'parameters' => array()
		);
	}	
}
