<?php
use \DSSpark\Models as DSSM;

class Clients extends DSSM{

	// Clients
	/**
	* @var Table Values
	*/
	public $client_id = null;
	public $full_name = null;
	public $added_date = null;	
	public $photo = null;
	/**
	* Sets the object's Clients using the values in the supplied array
	*
	* @param assoc The property values
	*/
	public function __construct($data=array()){

		if(isset($data['client_id'])) $this->client_id=(int)$data['client_id'];

		if(isset($data['full_name'])) $this->full_name=preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['full_name']);
		
		$this->added_date=date("Y-m-d");

		if(isset($data['photo'])) $this->photo=$data['photo'];
	}

	/**
	* Sets the object's clients using the edit form post values in the supplied array
	*
	* @param assoc The form post values
	*/
	public function storeFormValues($params){
		// Store all the parameters
		$this->__construct($params);
	}

	public function setQuota($clientId){
			$connQ  = DSSM::_sDBCon();
		 /*********QUOTA Table**********/
		    $sqlQ = "INSERT INTO clients(client_id) VALUES (:client_id)";

		    $stQ = $connQ->prepare($sqlQ);

		    $stQ->bindValue(":client_id",   $clientId, PDO::PARAM_INT);
		    $stQ->execute();

		    $connQ = null;
	}

	/**
	* Updates the current clients object in the database.
	*/
	public function updatePhoto($filename, $cid){
		$conn = DSSM::_sDBCon();
		$sql = "UPDATE clients
				SET photo=:photo
				WHERE client_id=:client_id";

    	$st = $conn->prepare($sql);

	    $st->bindValue(":photo", $filename, PDO::PARAM_STR);
		$st->bindValue(":client_id", $cid, PDO::PARAM_INT);

		$st->execute();
		$conn = null;
	}

	public function login($email, $pwd, $isGuest=0){ 

		   $conn = DSSM::_sDBCon();

			$sql = "SELECT email, password
					FROM clients 					
		    		WHERE email=:email AND password=:password";
	
		    $st = $conn->prepare($sql);
	
		    $usremail = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $email);
		    $usrpass = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $pwd);
	
		    $st->bindValue(":email", $usremail, PDO::PARAM_STR);
		    $st->bindValue(":password", Services::cypher($usrpass), PDO::PARAM_STR);
	
		    $st->execute();
		    $row = $st->fetch();
			    		
			if ( $st->rowCount() > 0 ){
				$_SESSION["useremail"]=$row["email"];
				return "OK";
			} else {
				return "No";
			}
			 $conn = null;
	}
}
?>