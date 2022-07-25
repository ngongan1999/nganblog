<?php  
class database{

	//DB Params
	private $dns = "mysql:host=bgdbq9xtsfrouhboayqj-mysql.services.clever-cloud.com;dbname=bgdbq9xtsfrouhboayqj";
	private $username = "u8uh7ses2upgvbyb";
	private $password = "QcT68RtaWuYWa252PXgN";
	private $conn;

	//DB Connect
	public function connect(){
		$this->conn = null;
		try{
			$this->conn = new PDO($this->dns,$this->username,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}catch(PDOException $e){
			echo "Connection failed: ".$e->getMessage();
		}

		return $this->conn;
	}
}

$database = new database();
$db = $database->connect();
?>

