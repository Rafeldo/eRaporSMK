<?php
class Core {

	// Function to validate the post data
	function validate_post($data){
		// Counter variable
		$counter = 0;
		// Validate the hostname
		if(isset($data['hostname']) AND !empty($data['hostname'])) {
			$counter++;
		}
		// Validate the username
		if(isset($data['db_user']) AND !empty($data['db_user'])) {
			$counter++;
		}
		// Validate the password
		if(isset($data['db_password']) AND !empty($data['db_password'])) {
		  // pass
		}
		// Validate the database
		if(isset($data['db_name']) AND !empty($data['db_name'])) {
			$counter++;
		}
		// Validate the site_name
		if(isset($data['admin_email']) AND !empty($data['admin_email'])) {
			$counter++;
		}
		// Validate the admin_username
		if(isset($data['admin_username']) AND !empty($data['admin_username'])) {
			$counter++;
		}
		// Validate the database
		if(isset($data['admin_password']) AND !empty($data['admin_password'])) {
			$counter++;
		}
		// Validate the admin_email
		if(isset($data['npsn']) AND !empty($data['npsn'])) {
			$counter++;
		}
		if(isset($data['nama_sekolah']) AND !empty($data['nama_sekolah'])) {
			$counter++;
		}
		// Check if all the required fields have been entered
		if($counter == '8') {
			return true;
		} else {
			return false;
		}
	}
	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}
	// Function to write the config file
	function write_config($data) {
		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';
		// Open the file
		$database_file = file_get_contents($template_path);
		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['db_user'],$new);
		$new  = str_replace("%PASSWORD%",$data['db_password'],$new);
		$new  = str_replace("%DATABASE%",$data['db_name'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0755);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
	function write_htaccess(){
		// Config path
		$template_path 	= 'config/.htaccess';
		$output_path 	= '../.htaccess';
		// Open the file
		$config_file = file_get_contents($template_path);
		$subfolder = str_replace('/','',substr($_SERVER["REQUEST_URI"], 0, -18));
		$new  = str_replace("%rewrite_base%","RewriteBase /".$subfolder, $config_file);
		// Write the new index.php file
		$handle = fopen($output_path,'w+');
		// Chmod the file, in case the user forgot
		@chmod($output_path,0755);
		// Verify file permissions
		if(is_writable($output_path)) {
			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}	
	}
}