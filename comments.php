<?php
require_once('mongo-config.php');

$id = $_POST['id'];

$post = $collection->findOne(array('_id' => new MongoId($id)));

	$comment = array(
		'name' => $_POST['name'],
		'email' => $_POST['email'],
		'comment' => $_POST['comment'],
		'posted_date' => new MongoDate() 
		
		);
	
	$collection ->update(array('_id' => new MongoId($id)),array('$push' => array('comments' => $comment))); //Push comments array via $push modifier
	header('Location: blogpost.php?id='.$id); //Redirect to current post
?>