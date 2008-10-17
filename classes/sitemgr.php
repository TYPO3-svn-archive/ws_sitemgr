<?php 


abstract class sitemgr {
	
	protected $hoteldata;
	protected $serverdata;
	
	
	/**
	 * 
	 */
	function __construct($hoteldata) {

		$this->hoteldata = $hoteldata;
	
	}
	
	/**
	 * 
	 */
	function __destruct() {
		
	//TODO - Insert your code here
	}
}


?>