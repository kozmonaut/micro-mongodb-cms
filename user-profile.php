<?php
require('session.php');
require('user.php');

$user = new User();
$pageTitle = $user->username;

if (!$user->isLoggedIn()){
	header('location: user-login.php');
exit;
}
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
		
		<h3>Welcome, <?php echo $user->username;?></h3>
		<p>Here you can find informations about your account.</p>
		<h4>Profile info</h4>
		<p>Nickname: <?php echo $user->nickname;?></p>
		<p>Email: <?php echo $user->email;?></p>
		<h4>About</h4>
		<p></p>
	
	</div>
			<a href="#" class="btn_top">Back To Top</a>	

</div>
	<?php include('footer.php');?>

	<?php include('/js/scripts.js');?>

</body>
</html>