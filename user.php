<?php
require_once('mongo-config.php');
require_once('session.php');

class User {

	const COLLECTION = 'users';
	private $_db;
	private $_collection;
	private $_user;
	
public function __construct() {

$this->_db = sessConnection::instantiate();
$this->_collection = $this->_db->setCollection(User::COLLECTION);

if ($this->isLoggedIn()) $this->_loadData();

}

public function isLoggedIn() {

return isset($_SESSION['user_id']);
}

public function authenticate($username, $password) {

	$query = array(
		'username' => $username,
		'password' => sha1($password)
	);
	
	$this->_user = $this->_collection->findOne($query);
	
	if (empty($this->_user)) return False;
	$_SESSION['user_id'] = (string) $this->_user['_id'];
	return True;
}

public function logout() {

unset($_SESSION['user_id']);
}

public function __get($attr) {

	if (empty($this->_user))
		return NULL;
	
	switch($attr) {
		case 'password':
			return NULL;

		default:
			return (isset($this->_user[$attr])) ?
			$this->_user[$attr] : NULL;

	}

}

private function _loadData() {

$id = new MongoId($_SESSION['user_id']);
$this->_user = $this->_collection->findOne(array('_id'=> $id));
}

}