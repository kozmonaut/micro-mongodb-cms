<?php
$pageTitle = 'Frontpage';

require_once('mongo-config.php'); // MongoDB Connection
require_once('user.php');
$user = new User();

$currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1; // Get current page
$limitPosts = 5; // Total numbers of posts per page
$skipPage = ($currentPage - 1) * $limitPosts;

$cursor = $collection->find(array(),array('title','content','published')); //Fetch title, content and a date for each post
$totalPosts = $cursor->count(); //Count number of posts
$totalPage = (int) ceil($totalPosts / $limitPosts); 

$cursor -> sort(array('published' => -1))->skip($skipPage)->limit($limitPosts); //Sort posts by date and show only 5 posts by page
?>

<?php include('header.php');?>

<body>

<div id="content">
	
	<div id="contentblock">
	
		<a href="index.php"><img src="images/logo.png"></a>
		
		<span class="label label-info" style="float:right;">
	<?php 
	if (!$user->isLoggedIn()){
		echo 'Welcome, guest! <a href="user-login.php">Login</a> or <a href="user-register.php">Register</a>';
	} else {
		echo "Welcome, <a href='user-profile.php'>.$user->username;</a>";
	}
	?>
	</span>
		
		<div id="menu">
			<ul class="nav nav-pills">
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Download</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#">News</a></li>
				<li><a href="#">Other</a></li>
			<!-- links -->
			</ul>
			</li>
			</ul>
		</div>
	
		<div class="jumbotrons">
		
			<h3>Micro Blog CMS based on MongoDB!</h3>
			<p>Easy to install, simple to use. Try it now!</p>
			<p><a href="#" class="btn btn-primary btn-lg">Find more</a></p>
		</div>
		
		<?php while ($cursor ->hasNext()): //Call posts from collection
				$post = $cursor->getNext(); ?>
				
	
		<div id="post">
			<h4># <a href="blogpost.php?id=<?php echo $post['_id'];?>"><?php echo $post['title'];?></a></h4>
			<p><?php echo substr($post['content'],0,500).'...';?></p>
			<p><a href="blogpost.php?id=<?php echo $post['_id'];?>" class="readMore">Read More</a></p>
			<!-- <p><?php echo $post['category']; ?></p>-->
		</div>
	
			<?php endwhile; ?>
	
		<div class="pagination">
		
			<?php if($currentPage !== 1): ?>
				<li><a href="<?php echo $_SERVER ['PHP_SELF'].'?page='.($currentPage - 1);?>">Previous</a></li>
			<?php endif;?>
	
			<?php if($currentPage !== $totalPage): ?>
				<li><a href="<?php echo $_SERVER ['PHP_SELF'].'?page='.($currentPage + 1);?>"s>Next</a></li>
			
			<?php endif;?>
			
		</div>
	
		<!--<div class="panel-footer">
		</div>-->
	
	</div>
			<a href="#" class="btn_top">Back To Top</a>

</div>
	<?php include('footer.php');?>

	<?php include('/js/scripts.js');?>

</body>
</html>
