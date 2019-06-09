<?php

class iMVC_Payment_Processor
{
	protected $db;
	
	function __construct()
	{
		$this->db = tmvc::instance()->controller->load->database();
	}
}
?>
