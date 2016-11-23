<?php
	//this function will check if on login/register page. so, there is no more script mess there
	function is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}
	
	//this function returns whether on index.php or not
	function is_index_page(){
		return in_array($GLOBALS['pagenow'], array('index.php'));
	}
?>