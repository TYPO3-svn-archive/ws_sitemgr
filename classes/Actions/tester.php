<?php 

class tester extends sitemgr {
	
	public function __construct($testdata){
		parent::__construct($testdata);
	}
	public function echoout() {
		return "Data: " . $this->hoteldata . " - Class: " . __CLASS__;
	}
}




?>