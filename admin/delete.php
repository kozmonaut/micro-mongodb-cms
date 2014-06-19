<?php require_once('../mongo-config.php');
$pageTitle = "Delete Post";

$id = $_REQUEST['id'];

$collection->remove(array('_id' => new MongoID($id)));
?>

<?php include('../header.php');?>

<div id="content">
	<div id="contentblock">
	<a href="dashboard.php"><img src="../images/logo.png"></a>
	
		<h1>Post successfully deleted!</h1>
		<p>Deleted post under _id: <b><?php echo $id;?></b>. | <a href="dashboard.php">Go back to Dashboard</a></p>
	</div>
</div>

	<?php include('../js/scripts.js');?>

</body>
</html>