<?php
// Database_info this class use to separate the database information in order to easy to change different database or connection.
class Database_Info
{
	private $dbhost      = 'localhost';
	private $schemaname = 'YuKai200465333';
	private $dbname     = 'root';
	private $dbpassword = '';
	public $conn;

	// create and check connection
	public function __construct(){
		if(!isset($this->conn)) {
			try {
				$dsn = "mysql:host=$this->dbhost;dbname=$this->schemaname";
				$conn = new PDO($dsn, $this->dbname, $this->dbpassword);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conn = $conn;
				return $this->conn;
			} catch (PDOException $e) {
				die("Failed to connect with mySQL database" . $e->getMessage());
			}
		}
	}
}