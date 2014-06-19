<?php 
	require_once('mongo-config.php');
	$id = $_GET['id'];
	$post = $collection->findOne(array('_id' => new MongoId($id))); // Return article based on _id value
	
	$pageTitle = $post['title'];
?>
	
<?php include('header.php');?>

<body>
<div id="content">
	<div id="contentblock">
		<a href="index.php"><img src="images/logo.png"></a><a class="addthis_counter addthis_pill_style" style="margin-left:210px;right;margin-top:15px;"></a>
	
		<div id="menu">
			<ul class="nav nav-pills">
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Download</a></li>
				<li><a href="#">How To Use</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#">Category 1</a></li>
				<li><a href="#">Category 2</a></li>
				<li><a href="#">Category 3</a></li>
			<!-- links -->
			</ul>
			</li>
			</ul>
		</div>
	
		<div id="post">
			<h2><?php echo $post['title'];?></h2>
			<img src="images/date.png"> <?php print date('F j Y, g:i a', $post['published']->sec);?><!-- Show Mongo date in a readable format -->
			<p><?php echo $post['content'];?></p>
			<span class="label label-warning">Category</span> <?php echo $post['category'];?>
		
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style" style="text-align:left;">
				<h3>Share this post</h3>
				
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_pinterest_pinit"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			</div>
			<br class="clear">
			<!-- AddThis Button END -->
	
		<div id="comments">
			<?php if (empty($post['comments'])):?>
		
				<div class="alert alert-info">Be first to comment! You must be <a href="user-register.php" style="text-decoration:underline;"> registered</a> for commenting!</div>
				<?php endif;?>
		
			<?php if (!empty($post['comments'])):?>
				<span class="label label-default">Comments</span><br></br>
			<?php foreach ($post['comments'] as $comment):
				echo date('F j Y, g:i a', $comment['posted_date']->sec).
				 ' | <b>"'.$comment['name'].'" replied..</b>';?>
			<div class="comm-show co-large"><?php echo $comment['comment'];?></div>
			
			<?php endforeach; 
			endif;?>
		</div>
		
		<div id="comments-reply">
			<span class="label label-info">Leave a reply</span><br></br>
			<form action="comments.php" method="post">
				<p><span>Name*</span></p>
				<input type="text" name="name" id="name" class="comments-form"/><br></br>
				<p><span>Email</span></p>
				<input type="text" name="email" class="comments-form"/><br></br>
				<p><span>Comment*</span></p>
				<textarea name="comment" rows="5"></textarea>
				<br></br>
				<input type="hidden" name="id" value="<?php echo $post['_id'];?>"/>			
				<input type="submit" name="btn_submit" class="btn_submit" value="Post comment"/>	
			
			</form>

		</div>
		
		</div>
	
	</div>
	
	</div>
	
	<?php include('footer.php');?>

	<?php include('js/scripts.js');?>

</body>
</html>