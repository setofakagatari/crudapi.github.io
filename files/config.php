<?php
class Database {
	
	private $db_host = 'db4free.net';
	private $db_name = 'crudapi12345';
	private $db_username = 'setofakagatari';
	private $db_password = 'trespatas31245';
	
	public function dbConnection () {
		try {
			$conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(PDOException $e){
			echo "connection error".$e->getMessage();
			exit;
		}
	}
}
?>