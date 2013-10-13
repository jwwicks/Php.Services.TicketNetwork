<?php
/**
 * @file ticketnetwork_state.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

/**
 * @class TNState
 * @brief TicketNetwork States and Provinces
 *
 * @since    0.0.1
 */
class TNState extends TicketNetworkBase{
	
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	
	public function get($params=false){

		$this->_request['method'] = 'GetStates';
		
		if($params){
			$this->set($params);
		}
		
		return $this;
	}
	
	
	public function search($params=null){
		$retval = false;
		
	    try{
    	    if(function_exists('apc_fetch')){
    			
    			if(apc_exists('States')){
    				$states = apc_fetch('States');
    			}else{
    				$states = $this->send('get', array('countryID'=>217))->results();
    				apc_store('States', $states, 86400);
    			}
    		}else{
    			$states = $this->send('get', array('countryID'=>217))->results();
    		}
    		
    		if($states){
    			foreach($states as $state){
    				foreach($params as $k=>$v){
    					if($state->$k == $params[$k]){
    						//pre($state);
    						$retval = $state;
    					}
    				}
    			}
    		}
	    }catch(Exception $e){
	        
	    }
	    
		return $retval;
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
				if(is_array($this->_response->GetStatesResult->States)){
					foreach($this->_response->GetStatesResult->States as $key => $value){
						foreach($value as $k => $v){
							if($v == 'United States of America'){
								$this->_data[] = (object) $value;
							}
						}
					}
				}else{
					$this->_data = $this->_response->GetPricingInfoResult;
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
