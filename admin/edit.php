<?php
require_once('../mongo_config.php');
$pageTitle = "Edit Post";

$check = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Save')) ? 'save_post' : 'show_form';
$id = $_REQUEST['id']; // Fetch current post id

switch($check){
	case 'save_post':
		$post = array();
		$post['title'] = $_POST['title'];
		$post['content'] = $_POST['content'];
		$post['tags'] = $_POST['tags'];
		$post['published'] = new MongoDate(); // New date on update
	
	$collection ->update(array('_id' => new MongoId($id)),$post); //Optional parameters: 'safe' => True, array('upsert' => True)
	
	break;
	
	case 'show_form':
	default:
		$post = $collection->findOne(array('_id' => new MongoId($id)));
}
?>

<!-- Post form -->

<?php include('../header');?>

<body>

	<div id="content">
		<div id="contentblock">
		
			<a href="dashboard.php"><img src="../images/logo.png"></a>

			<?php if ($check === 'show_form'): ?>

			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

			<h1>Edit post</h1>
			
			<h3>Title</h3>
			<p><input type="text" name="title" id="title/" value="<?php echo $post['title'];?>"/></p>
			
			<h3>Content</h3>
			<textarea name="content" rows="20"><?php echo $post['content'];?></textarea>
			<input type="hidden" name="id" value="<?php echo $post['_id'];?>"/>
			
			<h3>Tags</h3>
			<p><input type="text" name="tags" id="tags/" value="<?php echo $post['tags'];?>"/></p>
			
			<p><input type="submit" class="btn_submit" name="btn_submit" value="Save"/> 
			<a href="#" onclick="askdelete('<?php echo $post['_id'];?>')" class="btn_submit">Delete Post</a>
			<a href="dashboard.php" class="btn_submit">Return to Dashboard</a></p>
			</form>

			<?php else: ?>
			
			<h1>Post succesfully edited!</h1>
			<p>Post saved under_id: <b><?php echo $id;?></b>. 
			| <a href="../blogpost.php?id=<?php echo $id;?>" class="contentlink">Read post</a> | <a href="dashboard.php" class="contentlink">Return to Dashboard</a></p>

			<?php endif;?>
		</div>
	</div>

	<?php include('../footer.php');?>
	<?php include('../js/scripts.js');?>
	
</body>
</html>
