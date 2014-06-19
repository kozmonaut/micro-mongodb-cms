<?php
require_once('../user.php');
require_once('../session.php');
$user = new User();
$pageTitle = "Create post";

$check = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Save')) ? 'save_post' : 'show_form';

function check_fields($ar) {
	$empty = 0;
		if(is_array($ar)){
			foreach($ar as $field){
				if(empty($field)){
				$empty = 1;
				}
			}
				
		}
	return $empty;
	} // end check function

switch($check){
	case 'save_post':
	
			require_once('../mongo-config.php');
			
			$empty = check_fields($_POST);
			
			if($empty != 1){
				$post = array(
				'author'=>$_POST['author'],
				'title' => $_POST['title'],
				'content' => $_POST['content'],
				'category' => $_POST['category'],
				'published' => new MongoDate()
	
				);
			
			$collection->insert($post, array('safe' => True));
			
			
			echo '<h1>Post succesfully added!</h1><p>Post saved under_id: <b>', $post['_id'] .'</b>
				| <a href="post.php" class="contentlink">Add new post?</a> | <a href="../blogpost.php?id='.$post['_id'].'" class="contentlink">Read post</a> | <a href="dashboard.php" class="contentlink">Return to Dashboard</a></p>';
			
			}else {
				echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning!</strong> All fields require!</div>';
				
				header('refresh: 3, url=post.php');
	}
	 
	    break;
	 
	case 'show_form':
	    default:
	 
	 }
	 
?>

<?php include('../header.php');?>

	<div id="content">
		<div id="contentblock">
		
			<a href="dashboard.php"><img src="../images/logo.png"></a><a class="addthis_counter addthis_pill_style" style="margin-left:210px;right;margin-bottom:10px;"></a>

			<?php if ($check === 'show_form'): ?>

			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" accept-charset="UTF-8">

				<h1>Add new blog post</h1>
			
				<h3>Enter title here*</h3>
				<p><input type="text" name="title" id="title/"></p>
				<h3>Write content</h3>
				<textarea name="content" rows="20"></textarea>
				<h3>Category</h3>
				<p><input type="text" name="category" id="tags/"></p>
				<p><input type="submit" class="btn_submit" name="btn_submit" value="Save"/> <a href="dashboard.php" class="btn_submit">Return to Dashboard</a></p>
				
				<h3>Author</h3>
				<p><input type="text" name="author" id="author/" value="<?php echo $user->username;?>"></p>
			</form>

			<?php endif;?>
		</div>
	</div>
	
	<?php include('../footer.php');?>
	<?php include('../js/scripts.js');?>
	
</body>
</html>
