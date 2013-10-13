<?php 
/**
 * @file ticketnetwork_tickets.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

/**
 * @class TNTicket
 * @brief TicketNetwork Tickets
 *
 * @since    0.0.1
 */
class TNTicket extends TicketNetworkBase{
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	/**
	 *
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
	public function get($params=false){
	
		//$params = array('websiteConfigID' => WEB_CONF_ID, 'numberOfRecords' => TICKET_PAGINATION, 'eventID' => 1714400, 'lowPrice' => null, 'highPrice' => null, 'ticketGroupID' => null, 'mandatoryCreditCard' => null, 'requestedSplit' => null, 'sortColumn' => null, 'sortDescending' => null);
		$this->_request['method'] = 'GetTickets';
	
		if($params){
			$this->set($params);
			if(array_key_exists('eventID', $params)){
				$this->_request['method'] = 'GetEventTickets';
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
				if($this->_request['method'] == 'GetTickets'){
					if(is_array($this->_response->GetTicketsResult->TicketGroup)){
						foreach($this->_response->GetTicketsResult->TicketGroup as $ticket){
							$this->_data[] = $ticket;
						}
					}else{
						$this->_data = null;
					}
				}else{
					if(!empty($this->_response->GetEventTicketsResult->Tickets->TicketGroup)){
						foreach($this->_response->GetEventTicketsResult->Tickets->TicketGroup as $ticket){
							$this->_data[] = $ticket;
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
				'method' => 'GetTickets',
				'parameters' => array()
		);
	}
}
