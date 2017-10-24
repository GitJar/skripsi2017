<?php
//membuat koneksi ke database
if(!defined('core')) {
	exit('No Dice!');
} 

/**
* 
*/
class Database
{
	protected $db;

	private $db_host = DB_HOST;
	private $db_user = DB_USER;
	private $db_pass = DB_PASS;
	private $db_name = DB_NAME;	
	function connect()
	{
		# code...
		$this->db = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);

		if ($this->db->connect_error)
		{
			die('Database Error : <b>'.$this->db->connect_error.'</b>');
		}
		else
		{
			return $this->db; 
		}  
	}
}



?>