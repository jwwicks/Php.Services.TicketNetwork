<?php 
/**
 * @file ticketnetwork_performer.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

/**
 * @class TNPerformer
 * @brief TicketNetwork Performers
 *
 * @since    0.0.1
 */
if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

class TNPerformer extends TicketNetworkBase{
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	/**
	 * 	
	'WebsiteConfigID' => WEB_CONF_ID,
	'numReturned' => HIGH_INVENTORY_PERFORMERS_LENGTH,
	'parentCategoryID' => null,
	'childCategoryID' => null,
	'grandchildCategoryID' => null

	 * @param string $params
	 * @return TNPerformer
	 */
	public function get($params=false){
	
		$this->_request['method'] = 'GetEventPerformers';
	
		if($params){
			$this->set($params);
			if(array_key_exists('method', $params)){
				$this->_request['method'] = $params['method'];
				unset($params['method']);
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
				if($this->_request['method'] == 'GetEventPerformers'){
					if(is_array($this->_response->GetEventPerformersResult->EventPerformer)){
						foreach($this->_response->GetEventPerformersResult->EventPerformer as $performer){
							$this->_data[] = $performer;
						}
					}else{
						$this->_data = null;
					}
				}else if($this->_request['method'] == 'GetHighInventoryPerformers'){
					if(is_array($this->_response->GetHighInventoryPerformersResult->PerformerPercent)){
						foreach($this->_response->GetHighInventoryPerformersResult->PerformerPercent as $performer){
							$this->_data[] = $performer;
						}
					}else{
						$this->_data = null;
					}
				}else if($this->_request['method'] == 'GetHighSalesPerformers'){
					if(is_array($this->_response->GetHighSalesPerformersResult->PerformerPercent)){
						foreach($this->_response->GetHighSalesPerformersResult->PerformerPercent as $performer){
							$this->_data[] = $performer;
						}
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