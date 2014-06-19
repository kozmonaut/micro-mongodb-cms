<?php
require_once('mongo-config.php');

class Session {
	const COLLECTION = 'sessions'; // Collection for session storing
	const SESSION_TIMEOUT = 1200; // Session expire after 20 minutes
	const SESSION_LIFESPAN = 3600; // Session ID expire after 30 minutes
	const SESSION_NAME = 'mosession';
	
	const SESSION_COOKIE_PATH = '/';
	const SESSION_COOKIE_DOMAIN = '';

	private $_db;
	private $_collection;

	private $_currentSession;
	
public function __construct() {
	$this->_db = sessConnection::instantiate();
	$this->_collection = $this->_db->setCollection(Session::COLLECTION);

	// Set session methods
	session_set_save_handler(
		array(&$this, 'open'),
		array(&$this, 'close'),
		array(&$this, 'read'),
		array(&$this, 'write'),
		array(&$this, 'destroy'),
		array(&$this, 'gc')
		
	);

ini_set('session.gc_maxlifetime', Session::SESSION_LIFESPAN);

session_set_cookie_params(
	Session::SESSION_LIFESPAN, 
	Session::SESSION_COOKIE_PATH,
	Session::SESSION_COOKIE_DOMAIN
	);

	session_name(Session::SESSION_NAME); // Set session name
	session_cache_limiter('nocache');

session_start();

}

public function read($sessionId) {
	$query = array(
		'session_id' => $sessionId,
		'timedout_at' => array('$gte' => time()),
		'expired_at' => array('$gte' => time() - Session::SESSION_LIFESPAN));
		$find = $this->_collection->findOne($query);
		$this->_currentSession = $find;
	if(!isset($find['data'])) {
	return '';
}
	return $find['data'];
}

public function write($sessionId, $data) {
	$expired_at = time() + self::SESSION_TIMEOUT;

	$new_obj = array(
		'data' => $data,
		'timedout_at' => time() + self::SESSION_TIMEOUT,
		'expired_at' => (empty($this->_currentSession)) ? time()+ Session::SESSION_LIFESPAN : $this->_currentSession['expired_at']
);
	$query = array('session_id' => $sessionId);
	$this->_collection->update($query, array('$set' => $new_obj), array('upsert' => True)
);
	return True;
}

public function destroy($sessionId) {
	$this->_collection->remove(array('session_id' => $sessionId));
	return True;
}

public function gc() {
	$query = array( 'expired_at' => array('$lt' => time()));
	$this->_collection->remove($query);
	return True;
}

public function __destruct() {
	session_write_close();
}

public function open($path, $name) {
return true;
}

public function close() {
return true;
}

}

$session = new Session();