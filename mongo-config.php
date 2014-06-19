<?php

// Default Mongo connection

try{
    $mongo = New Mongo();
    $db = $mongo->micromongoblog;
    $collection = $db->posts;
    $users = $db->users;

} catch (MongoConnectionException $e){
    die ("Failed to connect to database". $e->getMessage());
    }

/*

Mongolab integration

try
{ 
    $connection = new Mongo('mongodb://<db-user>:<db-pass>@ds027738.mongolab.com:27738/micromongoblog'); 
    $database   = $connection->selectDB('micromongoblog'); 
    $collection = $database->selectCollection('posts'); 
    $users = $database->selectCollection('users');
}  
catch(MongoConnectionException $e)  
{ 
    die("Failed to connect to database ".$e->getMessage()); 
} 
*/

// Initialize connection to mongo for sessions
class sessConnection {
	
	// Class constants
	
	const DB = 'test'; // Use 'test' database
	
	private static $instance;
	public $connection;
	public $database;
	
	private function __construct() {
		
		try {
			
			$this->connection = new Mongo();
			$this->database = $this->connection->selectDB(sessConnection::DB);
			
		} catch (MongoConnectionException $check) {
			die('Connection failed: '. $check->getMessage());
		}
	}
	
	public static function instantiate() {
		
		if (!isset(self::$instance)){
			
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}
	
	public function setCollection($name) {
		
		return $this->database->selectCollection($name);
	}
	
}

?>
