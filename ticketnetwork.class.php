<?php 
/**
 * @file ticketnetwork.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!defined('MODE')){
	DEFINE('MODE', 'production');
}

if(!defined('TNWS')){
	require_once('tnwsConstants.php');
}

if(!class_exists('Custom_Exception')){
	require_once('custom_exception.class.php');
}

class TNException extends CustomException{}

/**
 * @interface ITicketNetwork 
 * @brief Interface class for TicketNetwork Objects
 *
 * @since    0.0.1
 */
interface ITicketNetwork {
	
	public function search($params=null);
	public function get($params=null);
	public function results();
}

/**
 * @interface IConfig
 * @brief Interface class for configuration settings objects
 *
 * @since    0.0.1
 */
interface IConfig {
	public function config($options);
	public function is($which, $value=true);
	public function has($which='errors', $target='data', $depth=3);
}

/**
 * @class TicketNetworkBase
 * @brief Abstract base class for concrete TicketNetwork Objects
 *
 * @since    0.0.1
 */
abstract class TicketNetworkBase implements ITicketNetwork, IConfig{
	
	protected $_data;
	protected $_map;
	protected $_options;
	protected $_request;
	protected $_response;
	protected $_writer;
	protected $_reader;
	
	public function search($params=null){}
	public function get($params=null){}
	public function results(){
		unset($this->_writer);
		return $this->_data;
	}

	
	/**
	 * Initializes the options array
	 *
	 * @param array $options - array of specific configuration options
	 * @throws Exception - when $options is not an array
	 */
	public function config($options){
		if(is_array($options)){
			if(PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 3){
				$this->_options = array_replace_recursive($this->_options, $options);
			}else{
				$this->_options = array_merge($this->_options, $options);
			}
		}else{
			throw new TNException('Invalid configuration options - array required');
		}
	
		return $this;
	}
	
	
	/**
	 * Sets the various options or request parameters
	 * 
	 * @param array $params - array of options to set
	 * @param string $target - which options to set. Defaults to _request['parameters']
	 * @throws TNException if $params is not an array
	 * @return TicketNetworkBase - concrete ticketNetwork Object
	 * @todo - fix $target for _request so there's only one set of merge statements
	 */
	public function set($params, $target='request'){
	
		if(is_array($params)){
			if($target == 'request'){
				if(PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 3){
					$this->_request['parameters'] = array_replace_recursive($this->_request['parameters'], $params);
				}else{
					$this->_request['parameters'] = array_merge($this->_request['parameters'], $params);
				}
				
			}else{
				$target = '_'.$target;
				if(PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 3){
					$this->$target = array_replace_recursive($this->$target, $params);
				}else{
					$this->$target = array_merge($this->$target, $params);
				}
			}
			
		}else{
			throw new TNException('Invalid data params - array required');
		}
	
		return $this;
	}
	
		
	/**
	 * Builds the request for sending to ticketnetwork
	 *
	 * @param string $which - type of request to build
	 * @see ITicketNetwork for supported operations or to expand/add support for other requests
	 */
	protected function build($which, $data=null){
	
		$this->_writer = new SoapClient($this->_endpoint(), array('cache_wsdl' =>  WSDL_CACHE_DISK));
		$this->_request['parameters']['websiteConfigID'] = $this->_options['websiteConfigID'];
		
		$this->$which($data);
	}
	
		
	/**
	 * Sends the request to ticketnetwork
	 */
	public function send($which='search', $data=null){
		
		if($data){
			$this->set($data);
		}
		
		try{
		    
		  $this->build($which, $data);
		
		  $this->_response = $this->_writer->__soapCall($this->_request['method'], array('parameters' => $this->_request['parameters']));
		  $this->parse();
		}catch(Exception $e){
		    $err = $this->debug($e->getMessage());
		    echo $err;
		}
		
		return $this;
	}
	
	
	/**
	 * Parse the response from ticketnetwork
	 * 
	 * @throws TNException - if last SOAP call failed
	 */
	public function parse(){
		if(is_soap_fault($this->_response)){
			throw new TNException('SOAP Fault: '. print_r($this->_response));
		}
		
		return $this;
	}
	
	
	/**
	 * Determines whether data exists for a given key
	 *
	 * @param string $which - key to check in data
	 * @return boolean - true if numeric data is > 0,
	 *                   string data is not empty,
	 *                   is an object
	 *                   or count of array results > 0,
	 *                   false otherwise
	 */
	public function has($which='errors', $target='data', $depth=3){
		$retval = false;
	
		$target = '_'.$target;
		
		if(is_array($this->$target)){

		    $iterator = new RecursiveIteratorIterator(
			    new RecursiveArrayIterator(
			        new ArrayObject($this->$target)
			     )
		      );
			
			foreach($iterator as $key=>$element){
				if($key == $which){
					$retval = true;
				}
			}	
		}
	
		return $retval;
	}
	
	
	/**
	 * Determines whether a setting has a particular value
	 *
	 * @param string $which - key in options array to check value
	 * @param mixed $value - value of setting to check against, default checks for boolean TRUE
	 * @return boolean - true if the setting matches supplied value, false otherwise or array key missing
	 */
	public function is($which, $value=true){
		$retval = false;
	
		if(array_key_exists($which, $this->_options) && $this->_options[$which] == $value){
			$retval = true;
		}
	
		return $retval;
	}
	
	/**
	 * Return the last reponse from TicketNetwork
	 */
	public function response(){
		return $this->_response;
	}
	
	/**
	 * Return the last request to TicketNetwork
	 */
	public function request(){
		return $this->_request;
	}

	/**
	 * Sets various default options for the transaction classes
	 */
	protected function _defaults(){
		$this->_options = array(
			'mode' => 'production',
			'fields' => array(),
			'endpoints' => array(
				'test' => 'http://tnwebservices-test.ticketnetwork.com/tnwebservice/v3.2/tnwebservicestringinputs.asmx?WSDL',
				'production' => 'http://tnwebservices.ticketnetwork.com/tnwebservice/v3.2/tnwebservicestringinputs.asmx?WSDL'
			),
			'websiteConfigID' => WEB_CONF_ID
		);
	
		$this->_data = array();
		$this->_map = array();
	}
	
	/**
	 * API URL endpoint
	 * @return string
	 */
	private function _endpoint(){
		return $this->_options['endpoints'][$this->_options['mode']];
	}

	/**
	 * For debugging
	 * @param string $message - message to display along with SOAP debugging info 
	 */
	public function debug($message = false){
	
		ob_start();
		
		echo "<pre style=\"background:#000;color:#fff;font-size:12px;padding:10px;\">";
		
		$requestHeaders = $this->_writer->__getLastRequestHeaders();
		$request = var_dump($this->_writer->__getLastRequest());
		$responseHeaders = $this->_writer->__getLastResponseHeaders();
		$response = var_dump($this->_writer->__getLastResponse());

		echo nl2br(htmlspecialchars($requestHeaders, true)) . "\n";
		echo highlight_string($request, true) . "\n";
	
		echo nl2br(htmlspecialchars($responseHeaders, true)) . "\n";
		echo highlight_string($response, true) . "\n";
		
		echo "</pre><br/>";
		
		$retval = ob_get_contents();
		ob_end_clean();
		
		return $retval;
	}
	
}

/**
 * @class TicketNetworkFactory
 * @brief Factory class for building/creating various concrete TicketNetwork Objects
 *
 * @since    0.0.1
 */
class TicketNetworkFactory implements IConfig{
	
	protected $_map = array();
	protected $_options = array();
	
	public function __construct($options=null){
	
		self::_defaults();
		
		if($options){
			self::config($options);
		}
		
	}
	
	/**
	 * Initializes the options array
	 *
	 * @param array $options - array of specific configuration options
	 * @throws Exception - when $options is not an array
	 */
	public function config($options, $target='options'){
		if(is_array($options)){
			$target = '_'.$target;
			if(PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 3){
				$this->$target = array_replace_recursive($this->$target, $params);
			}else{
				$this->$target = array_merge($this->$target, $params);
			}
		}else{
			throw new TNException('Invalid configuration options - array required');
		}
	
		return $this;
	}

	/**
	 * Determines whether data exists for a given key
	 *
	 * @param string $which - key to check in data
	 * @return boolean - true if numeric data is > 0,
	 *                   string data is not empty,
	 *                   is an object
	 *                   or count of array results > 0,
	 *                   false otherwise
	 */
	public function has($which='errors', $target='data', $depth=3){
		$retval = false;
	
		$target = '_'.$target;
	
		if(is_array($this->$target)){
		
		    $iterator = new RecursiveIteratorIterator(
		        new RecursiveArrayIterator(
		            new ArrayObject($this->$target)
		        )
		    );
		    	
		    foreach($iterator as $key=>$element){
		        if($key == $which){
		            $retval = true;
		        }
		    }
		}
		
		/*
		if(!empty($this->$target[$which]) && (
				(is_numeric($this->$target[$which]) && $this->$target[$which] > 0)
				|| (is_string($this->$target[$which]) && $this->$target[$which] != '')
				|| is_object($this->$target[$which])
				|| count($this->$target[$which]) > 0
		))
	    */
		
		return $retval;
	}
	
	
	/**
	 * Determines whether a setting has a particular value
	 *
	 * @param string $which - key in options array to check value
	 * @param mixed $value - value of setting to check against, default checks for boolean TRUE
	 * @return boolean - true if the setting matches supplied value, false otherwise or array key missing
	 */
	public function is($which, $value=true){
		$retval = false;
	
		if(array_key_exists($which, $this->_options) && $this->_options[$which] == $value){
			$retval = true;
		}
	
		return $retval;
	}	
	
	/**
	 * Factory method for creating a concrete ticketnetwork classes
	 *
	 * @param string $name - type of class to create
	 * @param array $args - arguments for the constructor of the created class
	 * @return TicketNetwork object specific to each type
	 */
	public function create($name, array $args=array()){
		$retval = false;
	
		try{
			
			if(!class_exists($this->_map['handlers'][$name])){
				require_once('ticketnetwork_'.$name.'.class.php');
			}
			
			$tnObj = new $this->_map['handlers'][$name]($args);
			$retval = $tnObj;
		}catch(Exception $e){
			die('Exception: '. $e->getMessage());
		}
	
		return $retval;
	}
	
	/**
	 * Return the current options in the factory object.
	 * Used for passing params to the init of various TN Objects
	 * 
	 * @return mixed array of options set with _defaults and config calls
	 */
	public function options(){
		return $this->_options;
	}
	
	
	/**
	 * Sets various default options for the factory
	 */
	private function _defaults(){
		$this->_map = array(
			'handlers' => array(
				'category'=>'TNCategory',
				'country'=>'TNCountry',
				'event'=>'TNEvent',
				'state'=>'TNState',
				'ticket'=>'TNTicket',
				'venue'=>'TNVenue',
				'performer'=>'TNPerformer',
			),
		);
		
		$this->_options = array(
			'mode'=>MODE
		);
	}
}
