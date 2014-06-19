<?php
$pageTitle = 'User Login';

$check = (!empty($_POST['login']) && ($_POST['login'] === 'Log in')) ? 'login' : 'show_form';

switch($check) {
	case 'login':
		require('session.php');
		require('user.php');
	
		$user = new User();
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if ($user->authenticate($username, $password)) {
			header('location: user-profile.php');
			exit;
		} else {
			$error = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning!</strong> All fields require!</div>';
	break;
	}
	case 'show_form':
	default:
		$error = NULL;
	}
?>

<?php include('header.php');?>

<body>

<div id="content">
	<div id="contentblock">
		
	<a href="index.php"><img src="images/logo.png"></a><a class="addthis_counter addthis_pill_style" style="margin-left:210px;right;margin-top:15px;"></a>
		
	<form id="login" action="user-login.php" method="post" accept-charset="UTF-8">
		
	<?php if(isset($error)): ?>
	<p><?php echo $error; ?></p>
	<?php endif ?>
	
	<h3>Username</h3>
	<p><input class="textbox" tabindex="1" type="text" name="username" autocomplete="off"/></p>

   	<h3>Password </h3>
	<p><input class="textbox" tabindex="2" type="password" name="password"/></p>

	<p><input class="btn_submit" name="login" tabindex="3" type="submit" value="Log in" /></p>
		
	</form>
	
	</div>
	
</div>
	
	<?php include('footer.php');?>

	<?php include('/js/scripts.js');?>

</body>
</html>
