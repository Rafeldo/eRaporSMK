<?php
session_start();
error_reporting(E_ALL); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.
$db_config_path = '../application/config/database.php';
// Only load the classes in case the user submitted the form
if($_POST) {
	require_once('includes/core_class.php');
	require_once('includes/Bcrypt.php');
	require_once('includes/database_class.php');
	$core = new Core();
	$database = new Database();
	// Validate the post data
	if($core->validate_post($_POST) == true){
		// First create the database, then create tables, then write config file
		$db_create = $database->create_database($_POST);
		if($db_create['success'] == false) {
			$message = $core->show_message('error', $db_create['msg']);
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod install/config/database.php file to 777");
		} else if ($core->write_htaccess() == false){
			$message = $core->show_message('error',"The htaccess file could not be written, please chmod install/config/.htaccess file to 777");
		}
		if(!isset($message)) {
		  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		  $redir .= "://".$_SERVER['HTTP_HOST'];
		  $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		  $redir = str_replace('install/','',$redir); 
		  header( 'Location: ' . $redir) ;
		}
	} else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, database name, admin email, admin password, npsn and nama sekolah are required.');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="assets/js/jquery-1.7.1.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="assets/js/script.js"></script>
		<link href="assets/css/style.css" rel="stylesheet">
		<title>Install | eRapor SMK Web Based</title>
	</head>
	<body>
    <?php if(is_writable($db_config_path)){?>
		  <form id="install_form" class="smart-blue" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		  <h1>eRapor Web Based Installation</h1>
		  <?php 
		  		if(isset($message)) { echo '<p class="alert alert-danger">' . $message . '</p>';}
		  		if(isset($_GET['e'])){
		  			$error = $_GET['e'];
		  			if($error == 'folder'){
		  				echo '<p class="alert alert-danger">Please delete or rename the <b>INSTALL FOLDER</b> to disable the installation script and then <a href="../"> Go to system</a></p>';
		  			}
		  			elseif ($error == 'db') {
		  				echo '<p class="alert alert-danger">The specified database does not exist, please set the correct database in <b> application/config/database.php </b> or run the installer again !!</p>';
		  			}
		  		}
		  ?>
		  <h3>Database Details</h3>
          <label for="hostname">Hostname</label><input type="text" id="hostname" value="<?php echo (isset($_POST['hostname'])) ? $_POST['hostname'] : 'localhost'; ?>" class="input_text" name="hostname" />
          <label for="username">Database User</label><input type="text" id="db_user" value="<?php echo (isset($_POST['db_user'])) ? $_POST['db_user'] : 'root'; ?>" class="input_text" name="db_user" />
          <label for="password">Database Password</label><input type="text" id="db_password" class="input_text" name="db_password" />
          <label for="database">Database Name</label><input type="text" id="db_name" value="<?php echo (isset($_POST['db_name'])) ? $_POST['db_name'] : 'db_erapor'; ?>" class="input_text" name="db_name" />
		  <h3>Administrator Account</h3>
		  <label for="admin_email">Email</label><input type="text" id="admin_email" value="<?php echo (isset($_POST['admin_email'])) ? $_POST['admin_email'] : ''; ?>" class="input_text" name="admin_email" />
		  <input type="hidden" id="admin_username"  value="Admin" class="input_text" name="admin_username" />
          <label for="admin_password">Password</label><input type="text" id="admin_password" class="input_text" name="admin_password" value="<?php echo (isset($_POST['admin_password'])) ? $_POST['admin_password'] : ''; ?>" />
          <div class="clr"></div>
		  <h3>Data Sekolah</h3>
		  <label for="npsn">NPSN</label>
		  <input type="text" id="npsn" value="<?php echo (isset($_POST['npsn'])) ? $_POST['npsn'] : ''; ?>" class="input_text" name="npsn" />
		  <label for="nama_sekolah">Nama Sekolah</label>
		  <input type="text" id="nama_sekolah" value="<?php echo (isset($_POST['nama_sekolah'])) ? $_POST['nama_sekolah'] : ''; ?>" class="input_text" name="nama_sekolah" />
		  <input type="submit" value="Install" class="button" id="submit" style="float:right"/>
          <div class="clr"></div>
		  </form>
	  <?php } else { ?>
      <p class="alert alert-danger">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
	  <?php } ?>	  
	</body>
</html>