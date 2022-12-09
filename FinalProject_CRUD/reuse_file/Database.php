<?php
require_once './reuse_file/Database_Info.php';

class Database
{
	private $db;

	// create connection via Database_Info class and store PDO
	public function __construct()
	{
		if(!isset($db)) {
			$dbInfo = new Database_Info();
			// store PDO >>> public $conn(PDO)
			$this->db = $dbInfo->conn;
		}
	}

	// insert(Create) Data
	public function insertData($tableName, $data){
		if(!empty($data) && is_array($data)){
			// insert: created data timestamp
			if(array_key_exists('created', $data)){
				$data['created'] = date("Y-m-d H:i:s");
			}
			// process data into string to fit query(PDO) statement
			$columns = implode(', ', array_keys($data));
			$values = ':' . implode(', :', array_keys($data));

			/* concat string using dot(.)
			$sql = "INSERT INTO " . $tableName . " ( " . $columns . " )  VALUES ( " . $values . ")";
			 */
			$sql = "INSERT INTO $tableName ( $columns ) VALUES ( $values )";
			// prepare query
			$stmt = $this->db->prepare($sql);
			foreach ($data as $key => $val){
				$stmt->bindValue(':' . $key, $val);
			}
			$insert = $stmt->execute();
			// return insert success or not
			return $insert ? $this->db->lastInsertId() : false;
		} else{
			return false;
		}
	}

	// read(display) data
	public function displayData($tableName, $conditions=array()){
		$sql = 'SELECT ';
		// multiple or single column, it may use checkbox
		if(array_key_exists('select', $conditions)){
			$selectValues = implode(',', $conditions['select']);
			$sql .= $selectValues;
		} else {
			$sql .= '*';
		}
		$sql .= ' FROM ';
		$sql .= $tableName;

		// where condition
		if(array_key_exists('where', $conditions)){
			$sql .= ' WHERE ';
			$i = 0;
			foreach($conditions['where'] as $key => $val){
				$pre = ($i>0) ? ' AND ' : '';
				$sql .= $pre.$key."='".$val."'";
				$i++;
			}
		}

		// order by condition
		if(array_key_exists('order_by', $conditions)){
			$sql .= ' ORDER BY ';
			$sql .= $conditions['order_by'];
		}

		// limit >>> (Offset correspond ['start'], Limit correspond ['limit'], ex: (9,11) will retrieve 10th - 20th row)
		if(array_key_exists('start', $conditions) &&
		array_key_exists('limit', $conditions)){
			$sql .= ' LIMIT ';
			$sql .= $conditions['start'] . ' ' .$conditions['limit'];
		}elseif(!array_key_exists('start', $conditions) &&
		array_key_exists('limit', $conditions)){
			$sql .= ' LIMIT ';
			$sql .= $conditions['limit'];
		}

		// prepare query and execute
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		// Other method to return data: return base on special require >>> all data, row count or all data associate by column
		if(array_key_exists('return_type', $conditions) &&
		$conditions['return_type'] != 'all'){
			switch ($conditions['return_type']){
				case 'count':
					$data = $stmt->rowCount();
					break;
				case 'single':
					//PDO::FETCH_ASSOC: Return next row as an array indexed by column name(return the result as an associative array.)
					/*The array keys will match your column names. If your table contains columns 'email' and 'password',
					    the array will be structured like:
						Array
						(
						    [email] => 'youremail@yourhost.com'
						    [password] => 'yourpassword'
						)

						To read data from the 'email' column, do:
						$user['email'];

						and for 'password':
						$user['password'];
					 *
					 */
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
					break;
				default:
					$data = '';
			}
		}else{
			if($stmt->rowCount() > 0){
				$data = $stmt->fetchAll();
			}
		}

		return !empty($data) ? $data : false;
	}

	// update data
	public function updateData($tableName, $data, $whereSetId){
		if(!empty($data) && is_array($data)){
			// Update : store a modified timestamp
			if(array_key_exists('modified', $data)){
				$data['modified'] = date("Y-m-d H:i:s");
			}

			$sql = 'UPDATE ';
			$sql .= $tableName;
			$sql .= ' SET ';

			// using named placeholder
			$set = [];       // store named placeholder query (columns)
			$setId = '';     // store named placeholder query (id) >>> where
			foreach ($data as $k => $v){
				if($k == $whereSetId) {
					$setId .= $k . ' = :' . $k;
				}else {
					$set[] .= $k . ' = :' . $k;
				}
			}
			$pre = implode(', ', $set);
			$sql .= $pre;
			$sql .= ' WHERE ';
			$sql .= $setId;
			// prepare and execute
			$stmt = $this->db->prepare($sql);
			return $stmt->execute($data);
		}
		return false;
	}

	// Delete Data via ID
	public function deleteDateById($tableName, $id, $whereDeleteIdName){
		$sql = 'DELETE FROM ' . $tableName;
		$sql .= ' WHERE ';
		$sql .= $whereDeleteIdName;
		// positional placeholder
		$sql .= '=?';
		$stmt = $this->db->prepare($sql);
		return $stmt->execute([$id]);
	}

	// check signup data whether valid
	public function inputErrorCheck_SignupUpdateData($data, $confirmPassword){
		if(!empty($data) && is_array($data)){
			if(array_key_exists('username', $data) && empty($data['username'])){
				return 'Username is required';
			} else {
				if(!preg_match("/^[a-zA-Z\d]{3,}$/", $data['username'])){
					return "Username length at least 3 character, and only can input valid character a to z, A to Z and 0 to 9!";
				}
			}
			if(array_key_exists('password', $data) && empty($data['password'])){
				return 'Password is required';
			} else {
				if(!preg_match("/^[A-Z\da-z]{3,}$/", $data['password'])){
					return "Password length at least 3 character, and only can input valid character a to z, A to Z and 0 to 9!";
				}
			}
			if(array_key_exists('password', $data) && $data['password'] != $confirmPassword){
				return "Confirm Password does not match the password";
			}
			if(array_key_exists('email', $data) && empty($data['email'])){
				return 'Email is required';
			} else {
				if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $data['email'])){
					return 'Email does not match the correct format';
				}
			}
			return true;
		}
	}

	// check input signup data whether exits in database
	public function checkSignupUpdateDataValid($tableName, $data, $conditions = array())
	{
		$sql = 'SELECT * FROM ' . $tableName;

		// query: find to check username
		// Add . "'" is in order to avoid special character or space
		$sql .= ' WHERE `username` = ' . "'" . $data['username'] . "'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// update check
		if(array_key_exists('updateUser', $conditions) && $stmt->rowCount() == 1){
			return true;
		// duplicate username
		}elseif($stmt->rowCount() > 0){
			return 'Username is not available! Try another one!';
		}

		// query: find to check email
		// Add . "'" is in order to avoid special character or space
		$sql = 'SELECT * FROM ' . $tableName;
		$sql .= " WHERE `email` = '" . $data['email'] . "'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// duplicate email
		if($stmt->rowCount() > 0){
			return 'Email is not available! Try another one!';
		}
		return true;
	}

	// check input login data whether exits in database
	public function checkLoginDataValid($tableName, $data){
		$sql = 'SELECT * FROM ' . $tableName;
		// query: find to check username and password are match in database
		// Add . "'" is in order to avoid special character or space
		$sql .= ' WHERE `username` = ' . "'" . $data['login_username'] . "'";
		$sql .= ' AND `password` = ' . "'" . $data['login_password'] . "'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if($stmt->rowCount() == 1){
			// why use foreach, because rwoCount() is array.
			foreach ($stmt as $row){
				// take user's id from database and store it in a session variable
				$_SESSION['user_id'] = $row['user_id'];
				header('Location:personalPage.php');
			}
		} else{
			header("Location:login.php?checkErrorMsg=Username or Password Incorrect!!!");
		}
	}
}