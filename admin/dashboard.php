<?php
require_once('../mongo-config.php');
$pageTitle = "Dashboard";

$currentPage = (isset($_GET['page'])) ? (int) $_GET['page'] : 1; // Get current page
$limitPosts = 8; // Total numbers of posts per page
$skipPage = ($currentPage - 1) * $limitPosts;

$cursor = $collection->find(array(),array('title','published')); //Fetch only title and date of post
$totalPosts = $cursor->count();
$totalPage = (int) ceil($totalPosts / $limitPosts);

$cursor -> sort(array('published' => -1))->skip($skipPage)->limit($limitPosts);

?>

<?php include('../header.php');?>

<body>
<div id="content">
	<div id="contentblock">
		<a href="dashboard.php"><img src="../images/logo.png"></a><a class="addthis_counter addthis_pill_style" style="margin-left:205px;margin-top:20px;"></a>
		<h1>Welcome to dashboard</h1>

		<div id="menu">
			<ul class="nav nav-pills">
				<li class="active"><a href="post.php">Add a post</a></li>
				<li><a href="#">Download</a></li>
				<li><a href="#">How To Use</a></li>
			</ul>
		</div>
	
	<table class="dashboard-posts">
	<thead>
		<tr>
			<th width="55%">Title</th>
			<th width="35%">Published at</th>
			<th width="20%">Action</th>
		</tr>
	</thead>
	<tbody>
	
	<?php while ($cursor->hasNext()):
		$post = $cursor->getNext();
	?>
		<tr>
		<td>
			<b><a href="../blogpost.php?id=<?php echo $post['_id'];?>"><?php echo substr($post['title'],0,100).'...';?></a></b>
		</td>
		<td>
			<?php print date('F j Y, g:i a', $post['published']->sec);?>
		</td>
		
		<td align="right">
			<a href="edit.php?id=<?php echo $post['_id'];?>"><img src="../images/edit.png" alt="Edit"></a> <a href="#" onclick="askdelete('<?php echo $post['_id'];?>')"><img src="../images/delete.png" alt="Delete"></a>
		</td>
		
		</tr>
		
		<?php endwhile;?>
	
	</tbody>
	</table>
	
	<div class="pagination">
		
			<?php if($currentPage !== 1): ?>
				<li><a href="<?php echo $_SERVER ['PHP_SELF'].'?page='.($currentPage - 1);?>">Previous</a></li>
			<?php endif;?>
	
			<?php if($currentPage !== $totalPage): ?>
				<li><a href="<?php echo $_SERVER ['PHP_SELF'].'?page='.($currentPage + 1);?>"s>Next</a></li>
			
			<?php endif;?>
	</div>
	
	<div id="dashboard-footer">
		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a href="#analytics" data-toggle="tab">Analytics</a></li>
			<li><a href="#comments" data-toggle="tab">Recent comments</a></li>
		</ul>
		
		<div class="tab-content">
		<div class="tab-pane active" id="analytics">
		<br class="clear">
			<p>Currently published posts: <?php echo $collection->find(array(),array('comments' => 1, 'name'=>1))->count();?></p>
			<p>Users registered: <?php echo $users->find(array(),array('users'=> 1))->count();?></p>
		</div>
		<div class="tab-pane" id="comments">
		<?php
		
		$cc = $collection->find(array('comments'=> array('name' => 'Kozmonaut')));
		print_r ($cc);
		?>
	
		</div>
		</div>
		
	</div>
	
</div>

</div>

	<?php include('../footer.php');?>
	<?php include('../js/scripts.js');?>

</body>
</html>