<?php

require_once('mongo-config.php');
$pageTitle = 'User register';
$connection = sessConnection::instantiate();
$user_collection = $connection->setCollection('users');

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
	} 

$check = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Save')) ? 'save_post' : 'show_form';

switch($check){
	case 'save_post':
			
			$empty = check_fields($_POST);
			
			if($empty != 1){
			
			$mongo = sessConnection::instantiate();
			$collection = $mongo->setCollection('users');
			
				$user = array(
				'username' => $_POST['username'],
				'nickname' => $_POST['nickname'],
				'email' => $_POST['email'],
				'password' => sha1($_POST['password']),
				'about' => $_POST['about'],
				'created' => new MongoDate()
	
				);
			
			$error = NULL;
			
			$collection->insert($user);
				$success = '<h3>User succesfully added!</h3>'.
				 '<a href="index.php" class="contentlink">Return to homepage</a> or take me to <a href="user-login.php">login</a> page</p>';
			
			} else {
				$success = NULL;
				$error = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Warning!</strong> All fields require!</div>';
	}
	 
	    break;
	 
	case 'show_form':
	    default:
		$success = NULL;
		$error = NULL;
	 }

?>

<?php include('header.php');?>

<body>
	<div id="content">
		<div id="contentblock">
		
			<a href="admin/dashboard.php"><img src="images/logo.png"></a><a class="addthis_counter addthis_pill_style" style="margin-left:210px;right;margin-bottom:10px;"></a>

			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" accept-charset="UTF-8">

				<h1>User register</h1>				

				<h3>Username</h3>
				<p><input type="text" name="username"></p>
				
				<h3>Nickname</h3>
				<p><input type="text" name="nickname"></p>
			
				<h3>Email</h3>
				<p><input type="text" name="email"></p>
				
				<h3>About</h3>
				<p>Tell us something about yourself.</p>
				<p><textarea rows="10" cols="30" name="about"></textarea></p>
				
				<h3>Password</h3>
				<p><input type="password" name="password"></p>
				<p><input type="submit" class="btn_submit" name="btn_submit" value="Submit"/> <a href="admin/dashboard.php" class="btn_submit">Return to Dashboard</a></p>
				
			</form>

			
		</div>
	</div>
	
	<?php include('footer.php');?>
	<?php include('js/scripts.js');?>
	
</body>
</html>
